<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\For_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Symplify\Astral\Naming\SimpleNameResolver;
use Symplify\Astral\NodeFinder\SimpleNodeFinder;
use Symplify\Astral\NodeValue\NodeValueResolver;
use Symplify\Astral\ValueObject\AttributeKey;
use Symplify\PackageBuilder\ValueObject\MethodName;
use Symplify\PHPStanRules\NodeFinder\StatementFinder;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Symplify\PHPStanRules\Tests\Rules\CheckConstantExpressionDefinedInConstructOrSetupRule\CheckConstantExpressionDefinedInConstructOrSetupRuleTest
 */
final class CheckConstantExpressionDefinedInConstructOrSetupRule implements Rule, DocumentedRuleInterface
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Move constant expression to __construct(), setUp() method or constant';

    public function __construct(
        private SimpleNameResolver $simpleNameResolver,
        private NodeValueResolver $nodeValueResolver,
        private SimpleNodeFinder $simpleNodeFinder,
        private StatementFinder $statementFinder
    ) {
    }

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Assign::class;
    }

    /**
     * @param Assign $node
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->var instanceof Variable) {
            return [];
        }

        $parent = $node->getAttribute(AttributeKey::PARENT);
        if (! $parent instanceof Node) {
            return [];
        }

        if ($parent instanceof For_) {
            return [];
        }

        if ($this->isNotInsideClassMethodDirectly($parent)) {
            return [];
        }

        if ($this->statementFinder->isUsedInNextStatement($node, $parent)) {
            return [];
        }

        if ($this->isInInstatiationClassMethod($node)) {
            return [];
        }

        if (! $this->isConstantExpr($node->expr, $scope)) {
            return [];
        }

        return [self::ERROR_MESSAGE];
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(self::ERROR_MESSAGE, [
            new CodeSample(
                <<<'CODE_SAMPLE'
class SomeClass
{
    public function someMethod()
    {
        $mainPath = getcwd() . '/absolute_path';
        return __DIR__ . $mainPath;
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeClass
{
    private $mainPath;

    public function __construct()
    {
        $this->mainPath = getcwd() . '/absolute_path';
    }

    public function someMethod()
    {
        return $this->mainPath;
    }
}
CODE_SAMPLE
            ),
        ]);
    }

    private function isConstantExpr(Expr $expr, Scope $scope): bool
    {
        if ($expr instanceof ClassConstFetch) {
            return false;
        }

        $value = $this->nodeValueResolver->resolve($expr, $scope->getFile());
        if ($value === null) {
            return false;
        }

        return $value !== '';
    }

    private function isNotInsideClassMethodDirectly(Node $node): bool
    {
        $parent = $node->getAttribute(AttributeKey::PARENT);
        return ! $parent instanceof ClassMethod;
    }

    private function isInInstatiationClassMethod(Assign $assign): bool
    {
        $classMethod = $this->simpleNodeFinder->findFirstParentByType($assign, ClassMethod::class);
        if (! $classMethod instanceof ClassMethod) {
            return true;
        }

        return $this->simpleNameResolver->isNames($classMethod->name, [MethodName::CONSTRUCTOR, MethodName::SET_UP]);
    }
}

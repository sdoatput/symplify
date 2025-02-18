<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Symfony\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\Rule;
use Symfony\Component\Console\Command\Command;
use Symplify\Astral\Naming\SimpleNameResolver;
use Symplify\Astral\NodeFinder\SimpleNodeFinder;
use Symplify\PHPStanRules\NodeAnalyzer\AttributeFinder;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Symplify\PHPStanRules\Symfony\Tests\Rules\RequireNamedCommandRule\RequireNamedCommandRuleTest
 */
final class RequireNamedCommandRule implements Rule, DocumentedRuleInterface
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'The command is missing $this->setName("...") in configure() method';

    /**
     * @var string
     */
    private const COMMAND_ATTRIBUTE = 'Symfony\Component\Console\Attribute\AsCommand';

    public function __construct(
        private SimpleNameResolver $simpleNameResolver,
        private SimpleNodeFinder $simpleNodeFinder,
        private AttributeFinder $attributeFinder,
    ) {
    }

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param ClassMethod $node
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $this->simpleNameResolver->isName($node, 'configure')) {
            return [];
        }

        if (! $this->isInNonAbstractCommand($scope)) {
            return [];
        }

        if ($this->containsSetNameMethodCall($node)) {
            return [];
        }

        if ($this->hasAsCommandAttribute($node)) {
            return [];
        }

        return [self::ERROR_MESSAGE];
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(self::ERROR_MESSAGE, [
            new CodeSample(
                <<<'CODE_SAMPLE'
use Symfony\Component\Console\Command\Command;

final class SomeCommand extends Command
{
    public function configure()
    {
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
use Symfony\Component\Console\Command\Command;

final class SomeCommand extends Command
{
    public function configure()
    {
        $this->setName('some');
    }
}
CODE_SAMPLE
            ),
        ]);
    }

    private function containsSetNameMethodCall(ClassMethod|Node $node): bool
    {
        /** @var MethodCall[] $methodCalls */
        $methodCalls = $this->simpleNodeFinder->findByType($node, MethodCall::class);
        foreach ($methodCalls as $methodCall) {
            if (! $this->simpleNameResolver->isName($methodCall->var, 'this')) {
                continue;
            }

            if (! $this->simpleNameResolver->isName($methodCall->name, 'setName')) {
                continue;
            }

            return true;
        }

        return false;
    }

    private function isInNonAbstractCommand(Scope $scope): bool
    {
        $classReflection = $scope->getClassReflection();
        if (! $classReflection instanceof ClassReflection) {
            return false;
        }

        if ($classReflection->isAbstract()) {
            return false;
        }

        return $classReflection->isSubclassOf(Command::class);
    }

    private function hasAsCommandAttribute(ClassMethod $classMethod): bool
    {
        $class = $this->simpleNodeFinder->findFirstParentByType($classMethod, Class_::class);
        if (! $class instanceof Class_) {
            return false;
        }

        return $this->attributeFinder->hasAttribute($class, self::COMMAND_ATTRIBUTE);
    }
}

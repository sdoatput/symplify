<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\NodeAnalyzer;

use PhpParser\Node\Attribute;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Symplify\Astral\Naming\SimpleNameResolver;

final class AttributeFinder
{
    public function __construct(
        private SimpleNameResolver $simpleNameResolver
    ) {
    }

    /**
     * @return Attribute[]
     */
    public function findInClass(Class_ $class): array
    {
        $attributes = [];

        $targetNodes = array_merge($class->getMethods(), $class->getProperties(), [$class]);
        foreach ($targetNodes as $targetNode) {
            $attributes = array_merge($attributes, $this->findAttributes($targetNode));
        }

        return $attributes;
    }

    /**
     * @return Attribute[]
     */
    public function findAttributes(ClassMethod | Property | ClassLike | Param $node): array
    {
        $attributes = [];

        foreach ($node->attrGroups as $attrGroup) {
            $attributes = array_merge($attributes, $attrGroup->attrs);
        }

        return $attributes;
    }

    public function findAttribute(
        ClassMethod | Property | ClassLike | Param $node,
        string $desiredAttributeClass
    ): ?Attribute {
        $attributes = $this->findAttributes($node);

        foreach ($attributes as $attribute) {
            if (! $attribute->name instanceof FullyQualified) {
                continue;
            }

            if ($this->simpleNameResolver->isName($attribute->name, $desiredAttributeClass)) {
                return $attribute;
            }
        }

        return null;
    }

    public function hasAttribute(ClassLike | ClassMethod | Property | Param $node, string $desiredAttributeClass): bool
    {
        return (bool) $this->findAttribute($node, $desiredAttributeClass);
    }
}

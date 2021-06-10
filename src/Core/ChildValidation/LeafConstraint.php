<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

abstract class LeafConstraint implements LegacyExpression
{
    /**
     * @return array
     * (LegacyConstraintType, mixed)
     */
    abstract public function legacySerializeAsLeaf(): array;

    /**
     * @return array
     * (LegacyExpressionType, LegacyConstraintType, mixed)
     */
    final public function legacySerialize(): array
    {
        $as_leaf = $this->legacySerializeAsLeaf();
        return [LegacyExpressionType::EXACTLY_ONE(), $as_leaf[0], $as_leaf[1]];
    }
}

<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

/**
 * Class QuantifierConstraint
 * @package Zheltikov\Xhp\Core\ChildValidation
 */
abstract class QuantifierConstraint implements LegacyExpression
{
    /**
     * @var \Zheltikov\Xhp\Core\ChildValidation\Constraint
     */
    private $child;

    abstract public static function LEGACY_EXPRESSION_TYPE(): LegacyExpressionType;

    final public function __construct(Constraint $child)
    {
        $this->child = $child;
    }

    /**
     * @return array
     * (LegacyExpressionType, mixed, mixed)
     */
    final public function legacySerialize(): array
    {
        $inner = $this->child;
        $as_leaf = $inner->legacySerializeAsLeaf();
        if ($as_leaf !== null) {
            return [static::LEGACY_EXPRESSION_TYPE()->getValue(), $as_leaf[0], $as_leaf[1]];
        }

        return [
            static::LEGACY_EXPRESSION_TYPE()->getValue(),
            LegacyConstraintType::EXPRESSION()->getValue(),
            $inner->legacySerialize(),
        ];
    }

    /**
     * @return null
     */
    final public function legacySerializeAsLeaf() // : null
    {
        return null;
    }
}

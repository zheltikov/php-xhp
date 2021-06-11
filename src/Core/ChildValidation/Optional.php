<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

final class Optional extends QuantifierConstraint
{
    public static function LEGACY_EXPRESSION_TYPE(): LegacyExpressionType
    {
        return LegacyExpressionType::ZERO_OR_ONE();
    }
}

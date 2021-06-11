<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

final class AtLeastOneOf extends QuantifierConstraint
{
    public static function LEGACY_EXPRESSION_TYPE(): LegacyExpressionType
    {
        return LegacyExpressionType::AT_LEAST_ONE();
    }
}

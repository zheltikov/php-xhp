<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

final class AnyNumberOf extends QuantifierConstraint
{
    public static function LEGACY_EXPRESSION_TYPE(): LegacyExpressionType
    {
        return LegacyExpressionType::ANY_QUANTITY();
    }
}

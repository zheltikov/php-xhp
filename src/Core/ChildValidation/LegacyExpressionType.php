<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

use MyCLabs\Enum\Enum;

/**
 * Class LegacyExpressionType
 * @package Zheltikov\Xhp\Core\ChildValidation
 *
 * @extends Enum<LegacyExpressionType>
 *
 * @method static LegacyExpressionType EXACTLY_ONE()
 * @method static LegacyExpressionType ANY_QUANTITY()
 * @method static LegacyExpressionType ZERO_OR_ONE()
 * @method static LegacyExpressionType AT_LEAST_ONE()
 * @method static LegacyExpressionType SEQUENCE()
 * @method static LegacyExpressionType EITHER()
 */
class LegacyExpressionType extends Enum
{
    private const EXACTLY_ONE = 0;
    private const ANY_QUANTITY = 1;
    private const ZERO_OR_ONE = 2;
    private const AT_LEAST_ONE = 3;
    private const SEQUENCE = 4;
    private const EITHER = 5;
}

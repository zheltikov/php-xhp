<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

use MyCLabs\Enum\Enum;

/**
 * Class LegacyExpressionType
 * @package Zheltikov\PhpXhp\Core\ChildValidation
 *
 * @extends Enum<LegacyExpressionType>
 *
 * @method LegacyExpressionType EXACTLY_ONE()
 * @method LegacyExpressionType ANY_QUANTITY()
 * @method LegacyExpressionType ZERO_OR_ONE()
 * @method LegacyExpressionType AT_LEAST_ONE()
 * @method LegacyExpressionType SEQUENCE()
 * @method LegacyExpressionType EITHER()
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

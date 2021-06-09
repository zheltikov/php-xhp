<?php

namespace Zheltikov\PhpXhp\Core;

use MyCLabs\Enum\Enum;

/**
 * Class XHPChildrenExpressionType
 * @package Zheltikov\PhpXhp\Core
 *
 * @extends Enum<XHPChildrenExpressionType>
 *
 * @method XHPChildrenExpressionType SINGLE()
 * @method XHPChildrenExpressionType ANY_NUMBER()
 * @method XHPChildrenExpressionType ZERO_OR_ONE()
 * @method XHPChildrenExpressionType ONE_OR_MORE()
 * @method XHPChildrenExpressionType SUB_EXPR_SEQUENCE()
 * @method XHPChildrenExpressionType SUB_EXPR_DISJUNCTION()
 */
final class XHPChildrenExpressionType extends Enum
{
    private const SINGLE = 0; // :thing
    private const ANY_NUMBER = 1; // :thing*
    private const ZERO_OR_ONE = 2; // :thing?
    private const ONE_OR_MORE = 3; // :thing+
    private const SUB_EXPR_SEQUENCE = 4; // (expr, expr)
    private const SUB_EXPR_DISJUNCTION = 5; // (expr | expr)
}

<?php

namespace Zheltikov\PhpXhp\Core;

use MyCLabs\Enum\Enum;

/**
 * Class XHPChildrenConstraintType
 * @package Zheltikov\PhpXhp\Core
 *
 * @extends Enum<XHPChildrenConstraintType>
 *
 * @method XHPChildrenConstraintType ANY()
 * @method XHPChildrenConstraintType PCDATA()
 * @method XHPChildrenConstraintType ELEMENT()
 * @method XHPChildrenConstraintType CATEGORY()
 * @method XHPChildrenConstraintType SUB_EXPR()
 */
final class XHPChildrenConstraintType extends Enum
{
    private const ANY = 1;
    private const PCDATA = 2;
    private const ELEMENT = 3;
    private const CATEGORY = 4;
    private const SUB_EXPR = 5;
}

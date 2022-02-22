<?php

namespace Zheltikov\Xhp\Reflection;

use MyCLabs\Enum\Enum;

/**
 * Class XHPChildrenConstraintType
 * @package Zheltikov\Xhp\Core
 *
 * @extends Enum<XHPChildrenConstraintType>
 *
 * @method static XHPChildrenConstraintType ANY()
 * @method static XHPChildrenConstraintType PCDATA()
 * @method static XHPChildrenConstraintType ELEMENT()
 * @method static XHPChildrenConstraintType CATEGORY()
 * @method static XHPChildrenConstraintType SUB_EXPR()
 */
final class XHPChildrenConstraintType extends Enum
{
    private const ANY = 1;
    private const PCDATA = 2;
    private const ELEMENT = 3;
    private const CATEGORY = 4;
    private const SUB_EXPR = 5;
}

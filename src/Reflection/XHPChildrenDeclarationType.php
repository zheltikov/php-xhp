<?php

namespace Zheltikov\Xhp\Reflection;

use MyCLabs\Enum\Enum;

/**
 * Class XHPChildrenDeclarationType
 * @package Zheltikov\Xhp\Core
 *
 * @extends Enum<XHPChildrenDeclarationType>
 *
 * @method static XHPChildrenDeclarationType NO_CHILDREN()
 * @method static XHPChildrenDeclarationType ANY_CHILDREN()
 * @method static XHPChildrenDeclarationType EXPRESSION()
 */
final class XHPChildrenDeclarationType extends Enum
{
    private const NO_CHILDREN = 0;
    private const ANY_CHILDREN = 1;
    private const EXPRESSION = ~0;
}

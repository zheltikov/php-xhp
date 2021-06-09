<?php

namespace Zheltikov\PhpXhp\Reflection;

use MyCLabs\Enum\Enum;

/**
 * Class XHPChildrenDeclarationType
 * @package Zheltikov\PhpXhp\Core
 *
 * @extends Enum<XHPChildrenDeclarationType>
 *
 * @method XHPChildrenDeclarationType NO_CHILDREN()
 * @method XHPChildrenDeclarationType ANY_CHILDREN()
 * @method XHPChildrenDeclarationType EXPRESSION()
 */
final class XHPChildrenDeclarationType extends Enum
{
    private const NO_CHILDREN = 0;
    private const ANY_CHILDREN = 1;
    private const EXPRESSION = ~0;
}

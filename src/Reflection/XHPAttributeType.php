<?php

namespace Zheltikov\Xhp\Reflection;

use MyCLabs\Enum\Enum;

/**
 * Class XHPAttributeType
 * @package Zheltikov\Xhp\Core
 *
 * @extends Enum<XHPAttributeType>
 *
 * @method XHPAttributeType TYPE_STRING()
 * @method XHPAttributeType TYPE_BOOL()
 * @method XHPAttributeType TYPE_INTEGER()
 * @method XHPAttributeType TYPE_ARRAY()
 * @method XHPAttributeType TYPE_OBJECT()
 * @method XHPAttributeType TYPE_VAR()
 * @method XHPAttributeType TYPE_ENUM()
 * @method XHPAttributeType TYPE_FLOAT()
 */
final class XHPAttributeType extends Enum
{
    private const TYPE_STRING = 1;
    private const TYPE_BOOL = 2;
    private const TYPE_INTEGER = 3;
    private const TYPE_ARRAY = 4;
    private const TYPE_OBJECT = 5;
    private const TYPE_VAR = 6;
    private const TYPE_ENUM = 7;
    private const TYPE_FLOAT = 8;
}

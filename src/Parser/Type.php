<?php

namespace Zheltikov\Xhp\Parser;

use MyCLabs\Enum\Enum;

/**
 * Class Type
 * @package Zheltikov\Xhp\Parser
 *
 * @extends Enum<Type>
 *
 * @method Type XHP_TAG()
 * @method Type XHP_TAG_NAME()
 * @method Type XHP_TAG_BODY()
 *
 */
final class Type extends Enum
{
    private const XHP_TAG = 'xhp_tag';
    private const XHP_TAG_NAME = 'xhp_tag_name';
    private const XHP_TAG_BODY = 'xhp_tag_body';
}

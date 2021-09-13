<?php

namespace Zheltikov\Xhp\Parser;

use MyCLabs\Enum\Enum;

/**
 * Class Type
 * @package Zheltikov\Xhp\Parser
 *
 * @extends Enum<Type>
 *
 * @method Type WHITESPACE()
 * @method Type XHP_TAG()
 * @method Type XHP_TAG_NAME()
 * @method Type XHP_TAG_BODY()
 * @method Type CHILD_LIST()
 * @method Type XHP_TEXT()
 * @method Type XHP_ENTITY()
 * @method Type INJECTED()
 * @method Type ATTRIBUTES()
 * @method Type ATTRIBUTE()
 * @method Type ATTR_NAME()
 * @method Type ATTR_VALUE()
 *
 */
final class Type extends Enum
{
    private const WHITESPACE = 'whitespace';
    private const XHP_TAG = 'xhp_tag';
    private const XHP_TAG_NAME = 'xhp_tag_name';
    private const XHP_TAG_BODY = 'xhp_tag_body';
    private const CHILD_LIST = 'child_list';
    private const XHP_TEXT = 'xhp_text';
    private const XHP_ENTITY = 'xhp_entity';
    private const INJECTED = 'injected';
    private const ATTRIBUTES = 'attributes';
    private const ATTRIBUTE = 'attribute';
    private const ATTR_NAME = 'attr_name';
    private const ATTR_VALUE = 'attr_value';
}

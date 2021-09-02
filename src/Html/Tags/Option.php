<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\PCDataElement;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

final class Option extends PCDataElement
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'disabled' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'label' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'selected' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'value' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
        ];
    }

    /**
     * @var string
     */
    protected $tagName = 'option';
}

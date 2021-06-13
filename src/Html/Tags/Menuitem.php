<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Singleton;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Menuitem extends Singleton
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'checked' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'command' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'default' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
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
            'icon' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'radiogroup' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'type' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    'checkbox',
                    'command',
                    'radio',
                ],
                null, // defaultValue
                false, // required
            ],
        ];
    }

    /**
     * @var string
     */
    protected $tagName = 'menuitem';
}

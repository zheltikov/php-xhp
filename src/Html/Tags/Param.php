<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\PCDataElement;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Param extends PCDataElement
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'name' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
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
    protected $tagName = 'param';
}

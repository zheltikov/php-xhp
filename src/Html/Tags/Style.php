<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Category\Metadata;
use Zheltikov\PhpXhp\Html\UnescapedPCDataElement;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Style extends UnescapedPCDataElement implements Metadata
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'media' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'scoped' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'type' => [
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
    protected $tagName = 'style';
}

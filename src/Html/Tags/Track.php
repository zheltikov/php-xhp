<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Singleton;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Track extends Singleton
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'default' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'kind' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    'subtitles',
                    'captions',
                    'descriptions',
                    'chapters',
                    'metadata',
                ],
                null, // defaultValue
                false, // required
            ],
            'label' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'src' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'srclang' => [
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
    protected $tagName = 'track';
}

<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Singleton;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

final class Area extends Singleton implements Phrase, Flow
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'alt' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'coords' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'download' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'href' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'hreflang' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'media' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'ping' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'referrerpolicy' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    '',
                    'no-referrer',
                    'no-referrer-when-downgrade',
                    'same-origin',
                    'origin',
                    'strict-origin',
                    'origin-when-cross-origin',
                    'strict-origin-when-cross-origin',
                    'unsafe-url',
                ],
                null, // defaultValue
                false, // required
            ],
            'rel' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'shape' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    'circ',
                    'circle',
                    'default',
                    'poly',
                    'polygon',
                    'rect',
                    'rectangle',
                ],
                null, // defaultValue
                false, // required
            ],
            'target' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
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
    protected $tagName = 'area';
}

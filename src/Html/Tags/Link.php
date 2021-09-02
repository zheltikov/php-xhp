<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Metadata;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Singleton;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

final class Link extends Singleton implements Phrase, Metadata, Flow
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'as' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'color' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'crossorigin' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    '', //equiv to anonymous
                    'anonymous',
                    'use-credentials',
                ],
                null, // defaultValue
                false, // required
            ],
            'disabled' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
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
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'imagesizes' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'imagesrcset' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'integrity' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
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
                true, // required
            ],
            'sizes' => [
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
    protected $tagName = 'link';
}

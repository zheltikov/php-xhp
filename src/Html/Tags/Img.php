<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Embedded;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Interactive;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Singleton;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

// Iff Interactive when usemap is set
final class Img extends Singleton implements Phrase, Flow, Embedded, Palpable, Interactive
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
            'crossorigin' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    'anonymous',
                    'use-credentials',
                ],
                null, // defaultValue
                false, // required
            ],
            'decoding' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    'async',
                    'auto',
                    'sync',
                ],
                null, // defaultValue
                false, // required
            ],
            'height' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'ismap' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'loading' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    'eager',
                    'lazy',
                ],
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
            'sizes' => [
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
            'srcset' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'usemap' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'width' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
        ];
    }

    /**
     * @var string
     */
    protected $tagName = 'img';
}

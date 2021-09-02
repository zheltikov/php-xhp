<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Metadata;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Singleton;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

// If itemprop is present, this element is allowed within the <body>.
final class Meta extends Singleton implements Phrase, Flow, Metadata
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'charset' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'content' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],

            // The correct definition of http-equiv is an enum, but there are
            // legacy values still used and any strictness here would only be
            // frustrating.
            'http-equiv' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],

            'name' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],

            // Facebook OG
            'property' => [
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
    protected $tagName = 'meta';
}

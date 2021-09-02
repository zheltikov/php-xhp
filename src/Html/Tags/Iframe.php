<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Embedded;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Interactive;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\PCDataElement;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

final class Iframe extends PCDataElement implements Phrase, Flow, Interactive, Embedded, Palpable
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'allow' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'allowfullscreen' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'allowpaymentrequest' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
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
            'height' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
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
            'sandbox' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'seamless' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
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
            'srcdoc' => [
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
    protected $tagName = 'iframe';
}

<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Html\Category\Embedded;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Interactive;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Embed extends Element implements Phrase, Flow, Interactive, Embedded, Palpable
{
    use Validation;

    /**
     * The HTML spec permits all non-namespaced attributes on the embed element.
     * It is safe to add these attributes to this class if you need them.
     * Make a PR against this repository.
     * Adding all attributes that are use 'in the wild' seems like the best
     * approach of this.
     */
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'height' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
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
            'type' => [
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

            /**
             * The following attributes are Flash specific.
             * Most notable use: youtube video embedding
             */
            'allowfullscreen' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'allowscriptaccess' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'always',
                    'never',
                ],
                null, // defaultValue
                false, // required
            ],
            'wmode' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
        ];
    }

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::any_of(
                ChildValidation::pcdata(),
                ChildValidation::of_type(Phrase::class)
            )
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'embed';
}

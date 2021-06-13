<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Embedded;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Interactive;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

// Iff Palpable when controls is true
final class Audio extends Element implements Phrase, Flow, Interactive, Embedded, Palpable
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'autoplay' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'controls' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
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
            'loop' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'mediagroup' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'muted' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'preload' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    'none',
                    'metadata',
                    'auto',
                ],
                null, // defaultValue
                false, // required
            ],
            'src' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
        ];
    }

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::sequence(
            ChildValidation::any_number_of(ChildValidation::of_type(Source::class)),
            ChildValidation::any_number_of(ChildValidation::of_type(Track::class)),
            ChildValidation::any_number_of(
                ChildValidation::any_of(
                    ChildValidation::pcdata(),
                    ChildValidation::of_type(Flow::class)
                )
            ),
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'audio';
}

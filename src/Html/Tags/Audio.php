<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Embedded;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Interactive;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Element;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

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

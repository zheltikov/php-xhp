<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Element;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

final class Progress extends Element implements Phrase, Flow, Palpable
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'max' => [
                XHPAttributeType::TYPE_FLOAT()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'value' => [
                XHPAttributeType::TYPE_FLOAT()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
        ];
    }

    // Should not contain :progress
    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::any_of(
                ChildValidation::pcdata(),
                ChildValidation::of_type(Phrase::class),
            )
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'progress';
}

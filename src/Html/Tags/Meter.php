<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Meter extends Element implements Phrase, Flow, Palpable
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'high' => [
                XHPAttributeType::TYPE_FLOAT()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'low' => [
                XHPAttributeType::TYPE_FLOAT()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'max' => [
                XHPAttributeType::TYPE_FLOAT()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'min' => [
                XHPAttributeType::TYPE_FLOAT()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'optimum' => [
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

    // Should not contain :meter
    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::any_of(
                ChildValidation::pcdata(),
                ChildValidation::of_type(Phrase::class),
            ),
        );
    }

    protected string $tagName = 'meter';
}

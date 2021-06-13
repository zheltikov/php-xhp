<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Category\Sectioning;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Fieldset extends Element implements Flow, Sectioning, Palpable
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'disabled' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'form' => [
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
        ];
    }

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::sequence(
            ChildValidation::optional(ChildValidation::of_type(Legend::class)),
            ChildValidation::any_number_of(
                ChildValidation::any_of(
                    ChildValidation::pcdata(),
                    ChildValidation::of_type(Flow::class)
                )
            )
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'fieldset';
}

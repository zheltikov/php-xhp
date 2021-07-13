<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Table extends Element implements Flow, Palpable
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'border' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'sortable' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
        ];
    }

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::sequence(
            ChildValidation::optional(ChildValidation::of_type(Caption::class)),
            ChildValidation::any_number_of(ChildValidation::of_type(Colgroup::class)),
            ChildValidation::optional(ChildValidation::of_type(Thead::class)),
            ChildValidation::any_of(
                ChildValidation::sequence(
                    ChildValidation::of_type(Tfoot::class),
                    ChildValidation::any_of(
                        ChildValidation::at_least_one_of(ChildValidation::of_type(Tbody::class)),
                        ChildValidation::any_number_of(ChildValidation::of_type(Tr::class)),
                    ),
                ),
                ChildValidation::sequence(
                    ChildValidation::any_of(
                        ChildValidation::at_least_one_of(ChildValidation::of_type(Tbody::class)),
                        ChildValidation::any_number_of(ChildValidation::of_type(Tr::class)),
                    ),
                    ChildValidation::optional(ChildValidation::of_type(Tfoot::class)),
                ),
            ),
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'table';
}

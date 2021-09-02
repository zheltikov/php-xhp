<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Element;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

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

<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Th extends Element
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'abbr' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'colspan' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'headers' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'rowspan' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'scope' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [// extraType
                    'col',
                    'colgroup',
                    'row',
                    'rowgroup',
                ],
                null, // defaultValue
                false, // required
            ],
            'sorted' => [
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
                ChildValidation::of_type(Flow::class),
            )
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'th';
}

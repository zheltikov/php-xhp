<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Sectioning;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Td extends Element implements Sectioning
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
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

    protected string $tagName = 'td';
}
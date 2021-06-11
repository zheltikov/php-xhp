<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Ol extends Element implements Flow, Palpable
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'reversed' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'start' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'type' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    '1',
                    'a',
                    'A',
                    'i',
                    'I',
                ],
                null, // defaultValue
                false, // required
            ],
        ];
    }

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::of_type(Li::class)
        );
    }

    protected string $tagName = 'ol';
}

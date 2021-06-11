<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

// Iff Palpable when at least one li in children
final class Menu extends Element implements Flow, Palpable
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'label' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'type' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'popup',
                    'toolbar',
                ],
                null, // defaultValue
                false, // required
            ],
        ];
    }

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_of(
            ChildValidation::any_number_of(
                ChildValidation::any_of(
                    ChildValidation::of_type(Menuitem::class),
                    ChildValidation::of_type(Hr::class),
                    ChildValidation::of_type(Menu::class),
                ),
            ),
            ChildValidation::any_number_of(ChildValidation::of_type(Li::class)),
            ChildValidation::any_number_of(ChildValidation::of_type(Flow::class)),
        );
    }

    protected string $tagName = 'menu';
}

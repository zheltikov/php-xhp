<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Element;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

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

    /**
     * @var string
     */
    protected $tagName = 'menu';
}

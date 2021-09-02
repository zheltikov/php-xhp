<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Element;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

final class Html extends Element
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'manifest' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'xmlns' => [
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
            ChildValidation::of_type(Head::class),
            ChildValidation::of_type(Body::class),
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'html';
}

<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Sectioning;
use Zheltikov\PhpXhp\Html\Element;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Dialog extends Element implements Flow, Sectioning
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'open' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
        ];
    }

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::of_type(Flow::class);
    }

    /**
     * @var string
     */
    protected $tagName = 'dialog';
}

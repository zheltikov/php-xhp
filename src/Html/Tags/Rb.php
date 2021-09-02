<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Element;

class Rb extends Element
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::at_least_one_of(
            ChildValidation::any_of(
                ChildValidation::pcdata(),
                ChildValidation::of_type(Phrase::class),
            )
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'rb';
}

<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;

class Rt extends Element
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
    protected $tagName = 'rt';
}

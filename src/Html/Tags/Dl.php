<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Element;

final class Dl extends Element implements Flow, Palpable
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::sequence(
                ChildValidation::at_least_one_of(ChildValidation::of_type(Dt::class)),
                ChildValidation::at_least_one_of(ChildValidation::of_type(Dd::class))
            )
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'dl';
}

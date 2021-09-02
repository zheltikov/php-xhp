<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Element;

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

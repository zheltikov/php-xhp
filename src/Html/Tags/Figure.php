<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Category\Sectioning;
use Zheltikov\Xhp\Html\Element;

final class Figure extends Element implements Flow, Sectioning, Palpable
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_of(
            ChildValidation::sequence(
                ChildValidation::of_type(Figcaption::class),
                ChildValidation::at_least_one_of(ChildValidation::of_type(Flow::class)),
            ),
            ChildValidation::sequence(
                ChildValidation::at_least_one_of(ChildValidation::of_type(Flow::class)),
                ChildValidation::optional(ChildValidation::of_type(Figcaption::class)),
            ),
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'figure';
}

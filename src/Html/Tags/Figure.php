<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Category\Sectioning;
use Zheltikov\PhpXhp\Html\Element;

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

    protected string $tagName = 'figure';
}

<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Heading;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Element;

final class Hgroup extends Element implements Flow, Heading, Palpable
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::at_least_one_of(
            ChildValidation::any_of(
                ChildValidation::of_type(H1::class),
                ChildValidation::of_type(H2::class),
                ChildValidation::of_type(H3::class),
                ChildValidation::of_type(H4::class),
                ChildValidation::of_type(H5::class),
                ChildValidation::of_type(H6::class),
            ),
        );
    }

    protected string $tagName = 'hgroup';
}

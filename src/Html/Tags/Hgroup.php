<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Heading;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Element;

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

    /**
     * @var string
     */
    protected $tagName = 'hgroup';
}

<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Element;

final class Address extends Element implements Flow, Palpable
{
    use Validation;

    // May not contain %heading, %sectioning, :header, :footer, or :address
    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::any_of(
                ChildValidation::pcdata(),
                ChildValidation::of_type(Flow::class)
            )
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'address';
}

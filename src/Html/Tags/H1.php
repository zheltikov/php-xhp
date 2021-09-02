<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Heading;
use Zheltikov\Xhp\Html\Category\Palpable;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Element;

final class H1 extends Element implements Flow, Heading, Palpable
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::any_of(
                ChildValidation::pcdata(),
                ChildValidation::of_type(Phrase::class)
            )
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'h1';
}

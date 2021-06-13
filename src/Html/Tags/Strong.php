<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;

final class Strong extends Element implements Phrase, Flow, Palpable
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
    protected $tagName = 'strong';
}

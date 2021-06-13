<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;

final class Datalist extends Element implements Phrase, Flow
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_of(
            ChildValidation::at_least_one_of(ChildValidation::of_type(Phrase::class)),
            ChildValidation::any_number_of(ChildValidation::of_type(Option::class))
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'datalist';
}

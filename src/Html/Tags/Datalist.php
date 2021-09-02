<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Element;

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

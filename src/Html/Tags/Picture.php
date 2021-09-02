<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Embedded;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Element;

final class Picture extends Element implements Phrase, Flow, Embedded
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::sequence(
            ChildValidation::any_number_of(ChildValidation::of_type(Source::class)),
            ChildValidation::of_type(Img::class),
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'picture';
}

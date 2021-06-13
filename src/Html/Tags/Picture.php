<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Html\Category\Embedded;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;

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

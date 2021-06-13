<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Metadata;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;

final class Noscript extends Element implements Phrase, Metadata, Flow
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::any_of(
                ChildValidation::pcdata(),
                ChildValidation::of_type(Metadata::class),
                ChildValidation::of_type(Flow::class),
            ),
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'noscript';
}

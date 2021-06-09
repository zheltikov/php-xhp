<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Palpable;
use Zheltikov\PhpXhp\Html\Element;

class P extends Element implements Flow, Palpable
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        /* return XHPChild\any_number_of(
            XHPChild\any_of(
                XHPChild\pcdata(),
                XHPChild\of_type<Category\Phrase>(),
            ),
        ); */
    }

    protected string $tagName = 'p';
}

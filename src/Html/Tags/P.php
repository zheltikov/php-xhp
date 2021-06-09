<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Element;

class P extends Element
{
    // use XHPChild\Validation;

    /* protected static function getChildrenDeclaration(): XHPChild\Constraint
    {
        return XHPChild\any_number_of(
            XHPChild\any_of(
                XHPChild\pcdata(),
                XHPChild\of_type<Category\Phrase>(),
            ),
        );
    } */

    protected string $tagName = 'p';
}

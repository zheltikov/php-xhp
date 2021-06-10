<?php

namespace Zheltikov\PhpXhp\Html;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;

/**
 * Subclasses of :xhp:pcdata_elements may contain only string children.
 */
abstract class PCDataElement extends Element
{
    use Validation;

    final protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::pcdata()
        );
    }
}
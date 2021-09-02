<?php

namespace Zheltikov\Xhp\Html;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;

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
<?php

namespace Zheltikov\PhpXhp\Html;

/**
 * Subclasses of :xhp:pcdata_elements may contain only string children.
 */
abstract class PCDataElement extends \Zheltikov\PhpXhp\Html\Element
{
    // use \Facebook\XHP\ChildValidation\Validation;

    /* final protected static function getChildrenDeclaration(): \Facebook\XHP\ChildValidation\Constraint
    {
        return \Facebook\XHP\ChildValidation\any_number_of(
            \Facebook\XHP\ChildValidation\pcdata()
        );
    } */
}
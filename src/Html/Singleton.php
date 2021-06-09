<?php

namespace Zheltikov\PhpXhp\Html;

/**
 * Subclasses of :xhp:html_singleton may not contain children. When
 * rendered they will be in singleton (<img />, <br />) form.
 */
abstract class Singleton extends Element
{
    // use \Facebook\XHP\ChildValidation\Validation;

    /* protected static function getChildrenDeclaration(): \Facebook\XHP\ChildValidation\Constraint
    {
        return \Facebook\XHP\ChildValidation\empty();
    } */

    // <<__Override>>
    protected function stringify(): string
    {
        // FIXME maybe . ' />' ?
        return $this->renderBaseAttrs() . '>';
    }
}

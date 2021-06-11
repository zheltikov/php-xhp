<?php

namespace Zheltikov\PhpXhp\Html;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;

/**
 * Subclasses of :xhp:html_singleton may not contain children. When
 * rendered they will be in singleton (<img />, <br />) form.
 */
abstract class Singleton extends Element
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::empty();
    }

    // <<__Override>>
    protected function stringify(): string
    {
        // FIXME maybe . ' />' ?
        return $this->renderBaseAttrs() . '>';
    }
}

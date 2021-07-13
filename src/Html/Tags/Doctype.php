<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\Primitive;
use Zheltikov\PhpXhp\Lib\C;

/**
 * Render an <html /> element within a DOCTYPE, XHP has chosen to only support
 * the HTML5 doctype.
 */
final class Doctype extends Primitive
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::of_type(Html::class);
    }

    // <<__Override>>

    /**
     * @throws \Zheltikov\Invariant\InvariantException
     * @throws \Zheltikov\PhpXhp\Exceptions\RenderArrayException
     */
    protected function stringify(): string
    {
        return '<!DOCTYPE html>' . self::renderChild(C::onlyx($this->getChildren()));
    }
}

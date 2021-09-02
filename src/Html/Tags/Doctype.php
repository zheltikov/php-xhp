<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Core\Primitive;
use Zheltikov\Xhp\Lib\C;

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
     * @throws \Zheltikov\Xhp\Exceptions\RenderArrayException
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    protected function stringify(): string
    {
        return '<!DOCTYPE html>' . self::renderChild(C::onlyx($this->getChildren()));
    }
}

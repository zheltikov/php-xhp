<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

/** Verify that a new child declaration matches the legacy codegen. */
trait Validation
{
    // require extends x\node;

    abstract protected static function getChildrenDeclaration(): Constraint;

    /**
     * @return mixed
     */
    // <<__Override>>
    final protected static function __legacySerializedXHPChildrenDeclaration() // : mixed
    {
        return static::getChildrenDeclaration()->legacySerialize();
    }
}

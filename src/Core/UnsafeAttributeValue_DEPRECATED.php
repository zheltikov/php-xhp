<?php

namespace Zheltikov\Xhp\Core;

/**
 * INCREDIBLY DANGEROUS: Marks an object as being able to provide an HTML
 * string.
 *
 * This is useful when migrating to XHP for attribute values which are already escaped.
 * If the attribute contains unescaped double quotes, this will not escape them, which will break the runtime behavior.
 *
 * This must be used via `forceAttribute_DEPRECATED()`.
 */
abstract class UnsafeAttributeValue_DEPRECATED
{
    abstract public function toHTMLString(): string;

    final public function __toString(): string
    {
        return $this->toHTMLString();
    }
}

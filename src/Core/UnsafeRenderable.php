<?php

namespace Zheltikov\PhpXhp\Core;

/**
 * INCREDIBLY DANGEROUS: Marks an object as being able to provide an HTML
 * string.
 *
 * This is useful when migrating to XHP as it allows you to embed non-XHP
 * content, usually in combination with XHPAlwaysValidChild; see MIGRATING.md
 * for more information.
 */
interface UnsafeRenderable extends XHPChild
{
    public function toHTMLString(): string;
}

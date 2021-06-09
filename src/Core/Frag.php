<?php

namespace Zheltikov\PhpXhp\Core;

use Zheltikov\PhpXhp\Lib\Str;
use Zheltikov\PhpXhp\Lib\Vec;

/**
 * An <x:frag /> is a transparent wrapper around any number of elements. When
 * you render it just the children will be rendered. When you append it to an
 * element the <x:frag /> will disappear and each child will be sequentially
 * appended to the element.
 */
class Frag extends Primitive
{
    // <<__Override>>
    protected function stringify(): string
    {
        return Str::join(
            Vec::map(
                $this->getChildren(),
                function ($child) {
                    return self::renderChild($child);
                }
            ),
            ''
        );
    }
}

<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Singleton;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

final class Col extends Singleton
{
    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'span' => [
                XHPAttributeType::TYPE_INTEGER()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
        ];
    }

    protected string $tagName = 'col';
}

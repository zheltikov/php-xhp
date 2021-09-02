<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Singleton;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

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

    /**
     * @var string
     */
    protected $tagName = 'col';
}

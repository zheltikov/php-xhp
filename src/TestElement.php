<?php

namespace Zheltikov\PhpXhp;

// use Zheltikov\PhpXhp\Core\ChildValidation\LegacyExpressionType;
use Zheltikov\PhpXhp\Core\Element;
use Zheltikov\PhpXhp\Core\Node;

class TestElement extends Element
{
    /* protected static function __legacySerializedXHPChildrenDeclaration()
    {
        return [
            LegacyExpressionType::ANY_QUANTITY()->getValue(),
            null,
            null,
        ];
    } */

    protected function render(): Node
    {
        return '<p>' . \htmlspecialchars($this->getAttribute('text')) . '</p>';
    }
}

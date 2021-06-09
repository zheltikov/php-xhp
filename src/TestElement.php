<?php

namespace Zheltikov\PhpXhp;

// use Zheltikov\PhpXhp\Core\ChildValidation\LegacyExpressionType;
use Zheltikov\PhpXhp\Core\Element;
use Zheltikov\PhpXhp\Core\Node;
use Zheltikov\PhpXhp\Html\Tags\P;

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
        return new P(
            [], // ['...$' => $this], // attributes
            [ // children
                $this->getAttribute('text'),
                new P(
                    [],
                    [...$this->getChildren()]
                ),
            ]
        );
        // return '<p>' . \htmlspecialchars($this->getAttribute('text')) . '</p>';
    }
}

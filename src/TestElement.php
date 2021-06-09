<?php

namespace Zheltikov\PhpXhp;

// use Zheltikov\PhpXhp\Core\ChildValidation\LegacyExpressionType;
use Zheltikov\PhpXhp\Core\Element;
use Zheltikov\PhpXhp\Core\Frag;
use Zheltikov\PhpXhp\Core\Node;
use Zheltikov\PhpXhp\Core\XHPAttributeType;
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
        $para = new P(
            [],
            ['three']
        );

        $xhp = new P(
            ['...$' => $this], // attributes
            [ // children
                $this->getAttribute('the_title') . ': ' . $this->getAttribute('text'),
                new P(
                    [],
                    [...$this->getChildren()]
                ),
                new Frag(
                    [],
                    [
                        new P(
                            [],
                            ['one']
                        ),
                        new P(
                            [],
                            ['two', $para]
                        ),
                        $para,
                        $para,
                    ]
                ),
            ]
        );
        return $xhp;
        // return '<p>' . \htmlspecialchars($this->getAttribute('text')) . '</p>';
    }

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'the_title' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                'Lorem Ipsum', // defaultValue
                true, // required
            ],
        ];
    }
}

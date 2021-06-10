<?php

namespace Zheltikov\PhpXhp;

// use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
// use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
// use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\Element;
use Zheltikov\PhpXhp\Core\Frag;
use Zheltikov\PhpXhp\Core\Node;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;
use Zheltikov\PhpXhp\Html\Tags\P;

class TestElement extends Element
{
    // use Validation;

    /* protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any();
    } */

    protected function render(): Node
    {
        $para = new P(
            [],
            ['three']
        );

        $xhp = new Frag(
            [],
            [ // children
                $this->getAttribute('the_title') . ': ' . $this->getAttribute('text'),
                new P(
                    ['...$' => $this], // attributes
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
                        // $para, // uncomment to test UseAfterRenderException
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

<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\Node;
use Zheltikov\PhpXhp\Core\Primitive;
use Zheltikov\PhpXhp\Lib\Str;
use Zheltikov\PhpXhp\Lib\Vec;
use Zheltikov\PhpXhp\Reflection\XHPAttributeType;

/**
 * Render an HTML conditional comment. You can choose whatever you like as
 * the conditional statement.
 */
final class ConditionalComment extends Primitive
{
    use Validation;

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            'if' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                true, // required
            ],
        ];
    }

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_number_of(
            ChildValidation::any_of(
                ChildValidation::pcdata(),
                ChildValidation::of_type(Node::class)
            )
        );
    }

    // <<__Override>>

    /**
     * @throws \Zheltikov\PhpXhp\Exceptions\AttributeNotSupportedException
     * @throws \Zheltikov\PhpXhp\Exceptions\AttributeRequiredException
     */
    protected function stringify(): string
    {
        $html = '<!--[if ' . $this->getAttribute('if') . ']>';
        $html .= Str::join(
            Vec::map(
                $this->getChildren(),
                function ($child) {
                    return self::renderChild($child);
                }
            ),
            ''
        );
        $html .= '<![endif]-->';
        return $html;
    }
}

<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Core\Node;
use Zheltikov\Xhp\Core\Primitive;
use Zheltikov\Xhp\Lib\Str;
use Zheltikov\Xhp\Lib\Vec;
use Zheltikov\Xhp\Reflection\XHPAttributeType;

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
     * @throws \Zheltikov\Xhp\Exceptions\AttributeNotSupportedException
     * @throws \Zheltikov\Xhp\Exceptions\AttributeRequiredException
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

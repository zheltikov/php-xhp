<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

use Zheltikov\PhpXhp\Lib\C;
use Zheltikov\PhpXhp\Lib\Vec;

final class Sequence implements LegacyExpression
{
    /**
     * @var array
     * vec<T>
     */
    private $children;

    public function __construct(Constraint $a, Constraint $b, Constraint ...$rest)
    {
        $this->children = Vec::concat([$a, $b], $rest);
    }

    // (LegacyExpressionType, mixed, mixed)
    public function legacySerialize(): array
    {
        $it = [
            LegacyExpressionType::SEQUENCE()->getValue(),
            $this->children[0]->legacySerialize(),
            $this->children[1]->legacySerialize(),
        ];
        $rest = Vec::drop($this->children, 2);
        while (!C::is_empty($rest)) {
            $it = [
                LegacyExpressionType::SEQUENCE()->getValue(),
                $it,
                $rest[0]->legacySerialize(),
            ];
            $rest = Vec::drop($rest, 1);
        }

        return $it;
    }

    public function legacySerializeAsLeaf() // : null
    {
        return null;
    }
}

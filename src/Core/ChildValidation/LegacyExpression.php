<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

interface LegacyExpression extends Constraint
{
    /**
     * @return array
     * (LegacyExpressionType, mixed, mixed)
     */
    public function legacySerialize(): array;
}

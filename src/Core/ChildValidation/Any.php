<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

final class Any implements Constraint
{
    public function legacySerialize() // : mixed
    {
        return 1;
    }

    /**
     * @return array
     * (LegacyConstraintType, mixed)
     */
    public function legacySerializeAsLeaf(): array
    {
        return [LegacyConstraintType::ANY()->getValue(), null];
    }
}

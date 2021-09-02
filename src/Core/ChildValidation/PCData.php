<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

final class PCData extends LeafConstraint
{
    // <<__Override>>
    // (LegacyConstraintType, mixed)
    public function legacySerializeAsLeaf(): array
    {
        return [LegacyConstraintType::PCDATA()->getValue(), null];
    }
}

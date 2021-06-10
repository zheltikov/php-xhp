<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

final class PCData extends LeafConstraint
{
    // <<__Override>>
    // (LegacyConstraintType, mixed)
    public function legacySerializeAsLeaf(): array
    {
        return [LegacyConstraintType::PCDATA(), null];
    }
}

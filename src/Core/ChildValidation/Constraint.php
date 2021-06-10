<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

interface Constraint
{
    /**
     * @return mixed
     */
    public function legacySerialize(); // : mixed

    /**
     * @return ?array
     */
    public function legacySerializeAsLeaf(): ?array; // : ?(LegacyConstraintType, mixed);
}

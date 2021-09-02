<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

interface Constraint
{
    /**
     * @return mixed
     */
    public function legacySerialize(); // : mixed

    /**
     * @return ?array
     */
    public function legacySerializeAsLeaf(); // : ?array; // : ?(LegacyConstraintType, mixed);
}

<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

final class None implements Constraint
{
    public function legacySerialize() // : mixed
    {
        return 0;
    }

    public function legacySerializeAsLeaf() // : null
    {
        return null;
    }
}

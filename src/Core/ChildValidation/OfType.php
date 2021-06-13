<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

final class OfType extends LeafConstraint
{
    /**
     * @var string
     */
    private $classname;

    public function __construct(string $classname)
    {
        $this->classname = $classname;
    }

    // <<__Override>>
    // (LegacyConstraintType, string)
    public function legacySerializeAsLeaf(): array
    {
        return [
            LegacyConstraintType::CLASSNAME()->getValue(),
            $this->classname,
        ];
    }
}

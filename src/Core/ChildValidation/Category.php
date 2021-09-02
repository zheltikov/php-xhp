<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

use Zheltikov\Xhp\Lib\Str;

final class Category extends LeafConstraint
{
    /**
     * @var string
     */
    private $category;

    public function __construct(string $category)
    {
        $this->category = $category;
    }

    // <<__Override>>
    // (LegacyConstraintType, string)
    public function legacySerializeAsLeaf(): array
    {
        return [
            LegacyConstraintType::CATEGORY()->getValue(),
            Str::replace(
                Str::replace(
                    Str::strip_prefix($this->category, '%'),
                    ':',
                    '__'
                ),
                '-',
                '_'
            ),
        ];
    }
}

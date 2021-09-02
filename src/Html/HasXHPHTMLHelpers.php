<?php

namespace Zheltikov\Xhp\Html;

interface HasXHPHTMLHelpers
{
    // require extends x\node;

    public function addClass(string $class): self;

    public function conditionClass(bool $cond, string $class): self;

    public function requireUniqueID(): string;

    public function getID(): string;
}

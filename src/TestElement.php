<?php

namespace Zheltikov\PhpXhp;

class TestElement
{
    private string $text = '';

    public function __construct(string $text = '')
    {
        $this->text = $text;
    }

    public function render(): string
    {
        return '<p>' . \htmlspecialchars($this->text) . '</p>';
    }

    final public function __toString(): string
    {
        return $this->render();
    }
}

<?php

namespace Zheltikov\PhpXhp\Html;

use Zheltikov\PhpXhp\Lib\Assert;
use Zheltikov\PhpXhp\Lib\Str;

trait XHPHTMLHelpers // implements HasXHPHTMLHelpers
{
    // require extends x\node;

    /**
     * Appends a string to the "class" attribute (space separated).
     * @return $this
     * @throws \Exception
     */
    public function addClass(string $class): self
    {
        $current_class = $this->getAttributes()['class'] ?? '';
        Assert::invariant(
            is_string($current_class),
            'Attribute `class` must be string'
        );
        return $this->setAttribute('class', Str::trim($current_class . ' ' . $class));
    }

    /**
     * Conditionally adds a class to the "class" attribute.
     * @return $this
     * @throws \Exception
     */
    public function conditionClass(bool $cond, string $class): self
    {
        return $cond ? $this->addClass($class) : $this;
    }

    /**
     * Generates a unique ID (and sets it) on the "id" attribute. A unique ID
     * will only be generated if one has not already been set.
     * @throws \Exception
     */
    public function requireUniqueID(): string
    {
        $id = $this->getAttributes()['id'] ?? null;
        if ($id === null || $id === '') {
            // FIXME: why length is 5?
            $id = bin2hex(random_bytes(5));
            $this->setAttribute('id', $id);
        }
        return (string) $id;
    }

    /**
     * Fetches the "id" attribute, will generate a unique value if not set.
     * @throws \Exception
     */
    final public function getID(): string
    {
        return $this->requireUniqueID();
    }
}

<?php

namespace Zheltikov\PhpXhp\Reflection;

use Zheltikov\PhpXhp\Lib\Assert;
use Zheltikov\PhpXhp\Lib\C;
use Zheltikov\PhpXhp\Core\Node;

class ReflectionXHPClass
{
    /**
     * @var string
     * classname<Node>
     */
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
        Assert::invariant(
            \class_exists($this->className)
            && \in_array(Node::class, \class_parents($this->className)),
            'Invalid class name: %s',
            $this->className,
        );
    }

    public function getReflectionClass(): \ReflectionClass
    {
        return new \ReflectionClass($this->getClassName());
    }

    /**
     * @return string
     * classname<Node>
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    public function getChildren(): ReflectionXHPChildrenDeclaration
    {
        /** @var Node $class */
        $class = $this->getClassName();
        return $class::__xhpReflectionChildrenDeclaration();
    }

    public function getAttribute(string $name): ReflectionXHPAttribute
    {
        $map = $this->getAttributes();
        Assert::invariant(
            C::contains_key($map, $name),
            'Tried to get attribute %s for XHP element %s, which does not exist',
            $name,
            $this->getClassName(),
        );
        return $map[$name];
    }

    /**
     * @return array
     * dict<string, ReflectionXHPAttribute>
     */
    public function getAttributes(): array
    {
        /** @var Node $class */
        $class = $this->getClassName();
        return $class::__xhpReflectionAttributes();
    }

    /**
     * @return array
     * keyset<string>
     */
    public function getCategories(): array
    {
        /** @var Node $class */
        $class = $this->getClassName();
        return $class::__xhpReflectionCategoryDeclaration();
    }
}

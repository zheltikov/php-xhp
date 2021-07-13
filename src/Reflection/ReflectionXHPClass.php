<?php

namespace Zheltikov\PhpXhp\Reflection;

use ReflectionClass;
use Zheltikov\PhpXhp\Core\Node;
use Zheltikov\PhpXhp\Lib\C;

use function Zheltikov\Invariant\invariant;

class ReflectionXHPClass
{
    /**
     * @var string
     * classname<Node>
     */
    private $className;

    /**
     * @throws \Zheltikov\Invariant\InvariantException
     */
    public function __construct(string $className)
    {
        $this->className = $className;

        invariant(
            class_exists($this->className)
            && in_array(Node::class, class_parents($this->className)),
            'Invalid class name: %s',
            $this->className,
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass($this->getClassName());
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

    /**
     * @throws \Zheltikov\Invariant\InvariantException
     */
    public function getAttribute(string $name): ReflectionXHPAttribute
    {
        $map = $this->getAttributes();

        invariant(
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

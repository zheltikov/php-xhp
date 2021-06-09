<?php

namespace Zheltikov\PhpXhp\Reflection;

class ReflectionXHPChildrenDeclaration
{
    /**
     * @var mixed
     */
    private $data;
    private string $context;

    /**
     * @param string $context
     * @param mixed $data
     */
    public function __construct(string $context, $data)
    {
        $this->context = $context;
        $this->data = \Zheltikov\PhpXhp\Core\ChildValidation::normalize($data);
    }

    // <<__Memoize>>
    public function getType(): \Zheltikov\PhpXhp\Reflection\XHPChildrenDeclarationType
    {
        if (\is_iterable($this->data)) {
            return \Zheltikov\PhpXhp\Reflection\XHPChildrenDeclarationType::EXPRESSION();
        }
        return \Zheltikov\PhpXhp\Reflection\XHPChildrenDeclarationType::from($this->data);
    }

    // <<__Memoize>>
    public function getExpression(): \Zheltikov\PhpXhp\Reflection\ReflectionXHPChildrenExpression
    {
        try {
            // FIXME: create TypeAssertionException
            \Zheltikov\PhpXhp\Core\Assert::invariant(
                \is_iterable($this->data),
                "ReflectionXHPChildrenDeclaration's data must be a KeyedContainer"
            );
            return new \Zheltikov\PhpXhp\Reflection\ReflectionXHPChildrenExpression(
                $this->context,
                $this->data
            );
            // FIXME: create TypeAssertionException
        } catch (/* \TypeAssertionException */ \Exception $_) {
            throw new \Exception(
                'Tried to get child expression for XHP class ' . $this->context
                . ', but it does not have an expressions.'
            );
        }
    }

    public function __toString(): string
    {
        if ($this->getType() === \Zheltikov\PhpXhp\Reflection\XHPChildrenDeclarationType::ANY_CHILDREN()) {
            return 'any';
        }
        if ($this->getType() === \Zheltikov\PhpXhp\Reflection\XHPChildrenDeclarationType::NO_CHILDREN()) {
            return 'empty';
        }
        return $this->getExpression()->__toString();
    }
}

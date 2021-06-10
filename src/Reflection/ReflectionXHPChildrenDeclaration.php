<?php

namespace Zheltikov\PhpXhp\Reflection;

use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Lib\Assert;

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
        $this->data = ChildValidation::normalize($data);
    }

    // <<__Memoize>>
    public function getType(): XHPChildrenDeclarationType
    {
        if (\is_iterable($this->data)) {
            return XHPChildrenDeclarationType::EXPRESSION();
        }
        return XHPChildrenDeclarationType::from($this->data);
    }

    // <<__Memoize>>
    public function getExpression(): ReflectionXHPChildrenExpression
    {
        try {
            // FIXME: create TypeAssertionException
            Assert::invariant(
                \is_iterable($this->data),
                "ReflectionXHPChildrenDeclaration's data must be a KeyedContainer"
            );
            return new ReflectionXHPChildrenExpression(
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
        if ($this->getType() === XHPChildrenDeclarationType::ANY_CHILDREN()) {
            return 'any';
        }
        if ($this->getType() === XHPChildrenDeclarationType::NO_CHILDREN()) {
            return 'empty';
        }
        return $this->getExpression()->__toString();
    }
}

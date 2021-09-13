<?php

namespace Zheltikov\Xhp\Reflection;

use Exception;
use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Memoize;

use function Zheltikov\Invariant\invariant;

class ReflectionXHPChildrenDeclaration
{
    use Memoize\Helper;

    /**
     * @var mixed
     */
    private $data;
    /**
     * @var string
     */
    private $context;

    /**
     * @param string $context
     * @param mixed $data
     */
    public function __construct(string $context, $data)
    {
        $this->context = $context;
        $this->data = ChildValidation::normalize($data);
    }

    // TODO: test memoization
    public function getType(): XHPChildrenDeclarationType
    {
        if (is_iterable($this->data)) {
            return XHPChildrenDeclarationType::EXPRESSION();
        }

        return XHPChildrenDeclarationType::from($this->data);
    }

    // TODO: test memoization
    public function getExpression(): ReflectionXHPChildrenExpression
    {
        try {
            // FIXME: create TypeAssertionException
            invariant(
                is_iterable($this->data),
                "ReflectionXHPChildrenDeclaration's data must be a KeyedContainer"
            );

            return new ReflectionXHPChildrenExpression(
                $this->context,
                $this->data
            );
            // FIXME: create TypeAssertionException
        } catch (/* \TypeAssertionException */ Exception $_) {
            throw new Exception(
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

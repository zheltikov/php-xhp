<?php

namespace Zheltikov\PhpXhp\Reflection;

class ReflectionXHPChildrenExpression
{
    /**
     * @var array
     * KeyedContainer<arraykey, mixed>
     */
    private array $data;
    private string $context;

    public function __construct(
        string $context,
        array $data
    ) {
        $this->context = $context;
        $this->data = $data;
    }

    // <<__Memoize>>
    public function getType(): \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType
    {
        return \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::from($this->data[0]);
    }

    // <<__Memoize>>
    // (ReflectionXHPChildrenExpression, ReflectionXHPChildrenExpression)
    public function getSubExpressions(): array
    {
        $type = $this->getType();
        \Zheltikov\PhpXhp\Core\Assert::invariant(
            $type === \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::SUB_EXPR_SEQUENCE()
            || $type === \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::SUB_EXPR_DISJUNCTION(),
            'Only disjunctions and sequences have two sub-expressions - in %s',
            $this->context
        );
        try {
            // FIXME: create TypeAssertionException
            \Zheltikov\PhpXhp\Core\Assert::invariant(
                \is_iterable($this->data[1]),
                "ReflectionXHPChildrenExpression's data[1] must be a KeyedContainer"
            );
            \Zheltikov\PhpXhp\Core\Assert::invariant(
                \is_iterable($this->data[2]),
                "ReflectionXHPChildrenExpression's data[2] must be a KeyedContainer"
            );
            return [
                new ReflectionXHPChildrenExpression(
                    $this->context,
                    $this->data[1]
                ),
                new ReflectionXHPChildrenExpression(
                    $this->context,
                    $this->data[2]
                ),
            ];
            // FIXME: create TypeAssertionException
        } catch (\TypeAssertionException $_) {
            throw new \Exception('Data is not subexpressions - in ' . $this->context);
        }
    }

    // <<__Memoize>>
    public function getConstraintType(): \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType
    {
        $type = $this->getType();
        \Zheltikov\PhpXhp\Core\Assert::invariant(
            $type !== \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::SUB_EXPR_SEQUENCE()
            && $type !== \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::SUB_EXPR_DISJUNCTION(),
            'Disjunctions and sequences do not have a constraint type - in %s',
            $this->context,
        );
        return \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::from($this->data[1]);
    }

    // <<__Memoize>>
    public function getConstraintString(): string
    {
        $type = $this->getConstraintType();
        \Zheltikov\PhpXhp\Core\Assert::invariant(
            $type === \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::ELEMENT()
            || $type === \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::CATEGORY(),
            'Only element and category constraints have string data - in %s',
            $this->context,
        );
        $data = $this->data[2];
        \Zheltikov\PhpXhp\Core\Assert::invariant(\is_string($data), 'Expected string data');
        return $data;
    }

    // <<__Memoize>>
    public function getSubExpression(): ReflectionXHPChildrenExpression
    {
        \Zheltikov\PhpXhp\Core\Assert::invariant(
            $this->getConstraintType() === \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::SUB_EXPR(),
            'Only expression constraints have a single sub-expression - in %s',
            $this->context,
        );
        $data = $this->data[2];
        try {
            // FIXME: create TypeAssertionException
            \Zheltikov\PhpXhp\Core\Assert::invariant(
                \is_iterable($data),
                "ReflectionXHPChildrenExpression's data must be a KeyedContainer"
            );
            return new ReflectionXHPChildrenExpression(
                $this->context,
                $data
            );
            // FIXME: create TypeAssertionException
        } catch (\TypeAssertionException $_) {
            throw new \Exception(
                'Expected a sub-expression, got a ' . (\is_object($data) ? \get_class($data) : \gettype($data))
                . ' - in ' . $this->context
            );
        }
    }

    public function __toString(): string
    {
        switch ($this->getType()) {
            case \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::SINGLE():
                return $this->__constraintToString();

            case \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::ANY_NUMBER():
                return $this->__constraintToString() . '*';

            case \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::ZERO_OR_ONE():
                return $this->__constraintToString() . '?';

            case \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::ONE_OR_MORE():
                return $this->__constraintToString() . '+';

            case \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::SUB_EXPR_SEQUENCE():
                [$e1, $e2] = $this->getSubExpressions();
                return $e1->__toString() . ',' . $e2->__toString();

            case \Zheltikov\PhpXhp\Core\XHPChildrenExpressionType::SUB_EXPR_DISJUNCTION():
                [$e1, $e2] = $this->getSubExpressions();
                return $e1->__toString() . '|' . $e2->__toString();
        }
    }

    private function __constraintToString(): string
    {
        switch ($this->getConstraintType()) {
            case \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::ANY():
                return 'any';

            case \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::PCDATA():
                return 'pcdata';

            case \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::ELEMENT():
                return '\\' . $this->getConstraintString();

            case \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::CATEGORY():
                return '%' . $this->getConstraintString();

            case \Zheltikov\PhpXhp\Core\XHPChildrenConstraintType::SUB_EXPR():
                return '(' . $this->getSubExpression()->__toString() . ')';
        }
    }
}

<?php

namespace Zheltikov\PhpXhp\Reflection;

use Exception;
use TypeAssertionException;

use function Zheltikov\Invariant\invariant;
use function Zheltikov\Memoize\wrap;

class ReflectionXHPChildrenExpression
{
    /**
     * @var array
     * KeyedContainer<arraykey, mixed>
     */
    private $data;
    /**
     * @var string
     */
    private $context;

    public function __construct(
        string $context,
        array $data
    ) {
        $this->context = $context;
        $this->data = $data;
    }

    // TODO: test memoization
    public function getType(): XHPChildrenExpressionType
    {
        /** @var callable|null $fn */
        static $fn = null;

        if ($fn === null) {
            $fn = wrap(
                function (): XHPChildrenExpressionType {
                    return XHPChildrenExpressionType::from($this->data[0]);
                }
            );
        }

        return $fn();
    }

    // TODO: test memoization
    public function getSubExpressions(): array // (ReflectionXHPChildrenExpression, ReflectionXHPChildrenExpression)
    {
        /** @var callable|null $fn */
        static $fn = null;

        if ($fn === null) {
            $fn = wrap(
                function (): array {
                    $type = $this->getType();
                    invariant(
                        $type->getValue() === XHPChildrenExpressionType::SUB_EXPR_SEQUENCE()->getValue()
                        || $type->getValue() === XHPChildrenExpressionType::SUB_EXPR_DISJUNCTION()->getValue(),
                        'Only disjunctions and sequences have two sub-expressions - in %s',
                        $this->context
                    );
                    try {
                        // FIXME: create TypeAssertionException
                        invariant(
                            is_iterable($this->data[1]),
                            "ReflectionXHPChildrenExpression's data[1] must be a KeyedContainer"
                        );

                        invariant(
                            is_iterable($this->data[2]),
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
                    } catch (TypeAssertionException $_) {
                        throw new Exception('Data is not subexpressions - in ' . $this->context);
                    }
                }
            );
        }

        return $fn();
    }

    // TODO: test memoization
    public function getConstraintType(): XHPChildrenConstraintType
    {
        /** @var callable|null $fn */
        static $fn = null;

        if ($fn === null) {
            $fn = wrap(
                function (): XHPChildrenConstraintType {
                    $type = $this->getType();

                    invariant(
                        $type->getValue() !== XHPChildrenExpressionType::SUB_EXPR_SEQUENCE()->getValue()
                        && $type->getValue() !== XHPChildrenExpressionType::SUB_EXPR_DISJUNCTION()->getValue(),
                        'Disjunctions and sequences do not have a constraint type - in %s',
                        $this->context,
                    );

                    return XHPChildrenConstraintType::from($this->data[1]);
                }
            );
        }

        return $fn();
    }

    // TODO: test memoization
    public function getConstraintString(): string
    {
        /** @var callable|null $fn */
        static $fn = null;

        if ($fn === null) {
            $fn = wrap(
                function (): string {
                    $type = $this->getConstraintType();

                    invariant(
                        $type->getValue() === XHPChildrenConstraintType::ELEMENT()->getValue()
                        || $type->getValue() === XHPChildrenConstraintType::CATEGORY()->getValue(),
                        'Only element and category constraints have string data - in %s',
                        $this->context,
                    );

                    $data = $this->data[2];

                    invariant(is_string($data), 'Expected string data');

                    return $data;
                }
            );
        }

        return $fn();
    }

    // TODO: test memoization
    public function getSubExpression(): ReflectionXHPChildrenExpression
    {
        /** @var callable|null $fn */
        static $fn = null;

        if ($fn === null) {
            $fn = wrap(
                function (): ReflectionXHPChildrenExpression {
                    invariant(
                        $this->getConstraintType()->getValue() === XHPChildrenConstraintType::SUB_EXPR()->getValue(),
                        'Only expression constraints have a single sub-expression - in %s',
                        $this->context,
                    );

                    $data = $this->data[2];

                    try {
                        // FIXME: create TypeAssertionException
                        invariant(
                            is_iterable($data),
                            "ReflectionXHPChildrenExpression's data must be a KeyedContainer"
                        );

                        return new ReflectionXHPChildrenExpression(
                            $this->context,
                            $data
                        );
                        // FIXME: create TypeAssertionException
                    } catch (TypeAssertionException $_) {
                        throw new Exception(
                            'Expected a sub-expression, got a ' . (is_object($data) ? get_class($data) : gettype($data))
                            . ' - in ' . $this->context
                        );
                    }
                }
            );
        }

        return $fn();
    }

    public function __toString(): string
    {
        switch ($this->getType()->getValue()) {
            case XHPChildrenExpressionType::SINGLE()->getValue():
                return $this->__constraintToString();

            case XHPChildrenExpressionType::ANY_NUMBER()->getValue():
                return $this->__constraintToString() . '*';

            case XHPChildrenExpressionType::ZERO_OR_ONE()->getValue():
                return $this->__constraintToString() . '?';

            case XHPChildrenExpressionType::ONE_OR_MORE()->getValue():
                return $this->__constraintToString() . '+';

            case XHPChildrenExpressionType::SUB_EXPR_SEQUENCE()->getValue():
                [$e1, $e2] = $this->getSubExpressions();
                return $e1->__toString() . ',' . $e2->__toString();

            case XHPChildrenExpressionType::SUB_EXPR_DISJUNCTION()->getValue():
                [$e1, $e2] = $this->getSubExpressions();
                return $e1->__toString() . '|' . $e2->__toString();
        }
    }

    private function __constraintToString(): string
    {
        switch ($this->getConstraintType()->getValue()) {
            case XHPChildrenConstraintType::ANY()->getValue():
                return 'any';

            case XHPChildrenConstraintType::PCDATA()->getValue():
                return 'pcdata';

            case XHPChildrenConstraintType::ELEMENT()->getValue():
                return '\\' . $this->getConstraintString();

            case XHPChildrenConstraintType::CATEGORY()->getValue():
                return '%' . $this->getConstraintString();

            case XHPChildrenConstraintType::SUB_EXPR()->getValue():
                return '(' . $this->getSubExpression()->__toString() . ')';
        }
    }
}

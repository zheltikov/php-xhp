<?php

namespace Zheltikov\PhpXhp\Core;

use Zheltikov\PhpXhp\Core\ChildValidation\AnyNumberOf;
use Zheltikov\PhpXhp\Core\ChildValidation\AnyOf;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\LegacyConstraintType;
use Zheltikov\PhpXhp\Core\ChildValidation\LegacyExpressionType;

class ChildValidation
{
    private static bool $validateChildren = true;

    public static function is_enabled(): bool
    {
        return static::$validateChildren;
    }

    public static function enable(): void
    {
        static::$validateChildren = true;
    }

    public static function disable(): void
    {
        static::$validateChildren = false;
    }

    // -------------------------------------------------------------------------

    /**
     * @param mixed $x
     * @return mixed
     */
    public static function normalize($x)
    {
        if (
            // $x is (int, int, mixed)
            \is_array($x)
            && \is_int($x[0])
            && \is_int($x[1])
            && \array_key_exists(2, $x)
            // TODO: mimic
            && $x[0] === LegacyExpressionType::EXACTLY_ONE()->getValue()
            && $x[1] === LegacyConstraintType::EXPRESSION()->getValue()
        ) {
            return static::normalize($x[2]);
        }

        if (
            // $x is (int, mixed, mixed)
            \is_array($x)
            && \is_int($x[0])
            && \array_key_exists(1, $x)
            && \array_key_exists(2, $x)
        ) {
            return [$x[0], static::normalize($x[1]), static::normalize($x[2])];
        }

        return $x;
    }

    // -------------------------------------------------------------------------

    public static function any_number_of(Constraint $a): AnyNumberOf
    {
        return new AnyNumberOf($a);
    }

    public static function any_of(Constraint $a, Constraint $b, Constraint ...$rest): AnyOf
    {
        return new AnyOf($a, $b, ...$rest);
    }
}

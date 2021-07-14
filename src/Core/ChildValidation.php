<?php

namespace Zheltikov\PhpXhp\Core;

use Zheltikov\Memoize\Helper;
use Zheltikov\PhpXhp\Core\ChildValidation\Any;
use Zheltikov\PhpXhp\Core\ChildValidation\AnyNumberOf;
use Zheltikov\PhpXhp\Core\ChildValidation\AnyOf;
use Zheltikov\PhpXhp\Core\ChildValidation\AtLeastOneOf;
use Zheltikov\PhpXhp\Core\ChildValidation\Category;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation\LegacyConstraintType;
use Zheltikov\PhpXhp\Core\ChildValidation\LegacyExpressionType;
use Zheltikov\PhpXhp\Core\ChildValidation\None;
use Zheltikov\PhpXhp\Core\ChildValidation\OfType;
use Zheltikov\PhpXhp\Core\ChildValidation\Optional;
use Zheltikov\PhpXhp\Core\ChildValidation\PCData;
use Zheltikov\PhpXhp\Core\ChildValidation\Sequence;
use Zheltikov\Memoize;

class ChildValidation
{
    use Memoize\Helper;

    /**
     * @var bool
     */
    private static $validateChildren = true;

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
            is_array($x)
            && is_int($x[0])
            && is_int($x[1])
            && array_key_exists(2, $x)

            && $x[0] === LegacyExpressionType::EXACTLY_ONE()->getValue()
            && $x[1] === LegacyConstraintType::EXPRESSION()->getValue()
        ) {
            return static::normalize($x[2]);
        }

        if (
            // $x is (int, mixed, mixed)
            is_array($x)
            && is_int($x[0])
            && array_key_exists(1, $x)
            && array_key_exists(2, $x)
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

    /**
     * FIXME: a string is not always the best way to handle this
     *
     * @param string $type
     * @return \Zheltikov\PhpXhp\Core\ChildValidation\OfType
     */
    public static function of_type(string $type): OfType
    {
        return new OfType($type);
    }

    public static function pcdata(): PCData
    {
        return new PCData();
    }

    public static function sequence(Constraint $a, Constraint $b, Constraint ...$rest): Sequence
    {
        return new Sequence($a, $b, ...$rest);
    }

    // TODO: test memoization
    public static function any(): Any
    {
        /** @var callable|null $fn */
        static $fn = null;

        return static::memoize(
            $fn,
            function (): Any {
                return new Any();
            }
        );
    }

    public static function at_least_one_of(Constraint $a): AtLeastOneOf
    {
        return new AtLeastOneOf($a);
    }

    // TODO: test memoization
    public static function category(string $c): Category
    {
        /** @var callable|null $fn */
        static $fn = null;

        return static::memoize(
            $fn,
            function (string $c): Category {
                return new Category($c);
            },
            $c
        );
    }

    // TODO: test memoization
    public static function empty(): None
    {
        /** @var callable|null $fn */
        static $fn = null;
        
        return static::memoize(
            $fn,
            function (): None {
                return new None();
            }
        );
    }

    public static function optional(Constraint $a): Optional
    {
        return new Optional($a);
    }
}

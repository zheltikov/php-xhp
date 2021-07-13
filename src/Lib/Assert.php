<?php

namespace Zheltikov\PhpXhp\Lib;

use function Zheltikov\Invariant\{
    invariant,
    invariant_callback_register,
    invariant_violation,
};

/**
 * Class Assert
 * @package Zheltikov\PhpXhp\Core
 * @deprecated Use package `zheltikov/php-invariant` instead
 */
class Assert
{
    /**
     * @param mixed $condition
     * @param string $format
     * @param mixed ...$values
     * @throws \Zheltikov\Invariant\InvariantException
     * @deprecated Use `invariant` from `zheltikov/php-invariant` instead
     */
    public static function invariant($condition, string $format, ...$values): void
    {
        invariant($condition, $format, ...$values);
    }

    /**
     * @param string $format
     * @param mixed ...$values
     * @throws \Zheltikov\Invariant\InvariantException
     * @deprecated Use `invariant_violation` from `zheltikov/php-invariant`instead.
     */
    public static function invariant_violation(string $format, ...$values): void
    {
        invariant_violation($format, ...$values);
    }

    /**
     * @param callable $callback
     * @throws \Zheltikov\Invariant\InvariantException
     * @deprecated Use `invariant_callback_register` from `zheltikov/php-invariant` instead.
     */
    public static function invariant_callback_register(callable $callback): void
    {
        invariant_callback_register($callback);
    }
}

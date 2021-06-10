<?php

namespace Zheltikov\PhpXhp\Lib;

/**
 * Class Assert
 * @package Zheltikov\PhpXhp\Core
 * @todo Move this to a separate package
 */
class Assert
{
    /**
     * @var ?callable
     */
    private static $callback = null;

    /**
     * @param mixed $condition
     * @param string $format
     * @param mixed ...$values
     * @throws \Exception
     */
    public static function invariant($condition, string $format, ...$values): void
    {
        if (!$condition) {
            static::invariant_violation($format, ...$values);
        }
    }

    /**
     * @param string $format
     * @param mixed ...$values
     * @throws \Exception
     */
    public static function invariant_violation(string $format, ...$values): void
    {
        if (\is_callable(static::$callback)) {
            \call_user_func(static::$callback, $format, ...$values);
        } else {
            // FIXME: this may not be the best solution
            throw new \Exception(Str::format($format, ...$values));
        }
    }

    /**
     * @param callable $callback
     */
    public static function invariant_callback_register(callable $callback): void
    {
        static::$callback = $callback;
    }
}

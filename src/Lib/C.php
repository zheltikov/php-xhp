<?php

namespace Zheltikov\PhpXhp\Lib;

// TODO: move this to a separate package
class C
{
    public static function contains_key(array $container, string $key): bool
    {
        return \array_key_exists($key, $container);
    }

    public static function count(array $container): int
    {
        return \count($container);
    }

    public static function last(array $container) // : mixed
    {
        return \count($container) ? \end($container) : null;
    }

    public static function is_empty(array $container): bool
    {
        return static::count($container) === 0;
    }
}
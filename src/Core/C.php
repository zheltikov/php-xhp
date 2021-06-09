<?php

namespace Zheltikov\PhpXhp\Core;

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
}

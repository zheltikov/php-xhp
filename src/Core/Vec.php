<?php

namespace Zheltikov\PhpXhp\Core;

// TODO: move this to a separate package
class Vec
{
    public static function keys(array $array): array
    {
        return \array_keys($array);
    }

    public static function map(array $source, callable $callback): array
    {
        $result = [];
        foreach ($source as $value) {
            $result[] = \call_user_func($callback, $value);
        }
        return $result;
    }

    public static function reverse(array $source): array
    {
        return \array_reverse($source);
    }
}

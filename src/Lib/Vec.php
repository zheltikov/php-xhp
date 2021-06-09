<?php

namespace Zheltikov\PhpXhp\Lib;

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

    /**
     * @param array $array
     * @param mixed ...$rest
     * @return array
     * @todo Self-implement this
     */
    public static function concat(array $array, array ...$rest): array
    {
        return \array_merge($array, ...$rest);
    }

    public static function drop(array $source, int $count): array
    {
        return \array_slice($source, $count);
    }
}

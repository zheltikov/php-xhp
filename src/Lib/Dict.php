<?php

namespace Zheltikov\PhpXhp\Lib;

// TODO: move this to a separate package
class Dict
{
    public static function map_with_key(array $source, callable $callback): array
    {
        $result = [];
        foreach ($source as $key => $value) {
            $result[$key] = \call_user_func($callback, $key, $value);
        }
        return $result;
    }

    public static function map(array $source, callable $callback): array
    {
        return static::map_with_key(
            $source,
            function ($key, $value) use ($callback) {
                return \call_user_func($callback, $value);
            }
        );
    }

    public static function merge(array ...$arrays): array
    {
        $result = [];

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public static function filter(array $source, ?callable $callback = null): array
    {
        if ($callback === null) {
            $callback = function ($value): bool {
                return (bool) $value;
            };
        }

        $result = [];

        foreach ($source as $key => $value) {
            if (\call_user_func($callback, $value)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}

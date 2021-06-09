<?php

namespace Zheltikov\PhpXhp\Core;

class Str
{
    public static function starts_with(string $string, string $prefix): bool
    {
        return \strpos($string, $prefix) === 0;
    }

    /**
     * @param string $format
     * @param mixed ...$values
     * @return string
     */
    public static function format(string $format, ...$values): string
    {
        return \sprintf($format, ...$values);
    }

    public static function replace(
        string $haystack,
        string $needle,
        string $replacement
    ): string {
        return \str_replace($needle, $replacement, $haystack);
    }

    public static function join(array $pieces, string $glue): string
    {
        return \implode($glue, $pieces);
    }

    public static function trim(string $string): string
    {
        return \trim($string);
    }

    public static function length(string $string): int
    {
        return \strlen($string);
    }

    public static function slice(string $string, int $offset, ?int $length = null): string
    {
        return $length === null
            ? \substr($string, $offset)
            : \substr($string, $offset, $length);
    }

    public static function strip_prefix(string $string, string $prefix): string
    {
        if (!static::starts_with($string, $prefix)) {
            return $string;
        }

        $length = static::length($prefix);
        return static::slice($string, $length);
    }
}

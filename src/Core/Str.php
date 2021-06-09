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
}

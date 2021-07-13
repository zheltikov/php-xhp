<?php

namespace Zheltikov\PhpXhp\Lib;

// TODO: move this to a separate package
use function Zheltikov\Invariant\invariant;

class C
{
    public static function contains_key(array $container, string $key): bool
    {
        return array_key_exists($key, $container);
    }

    public static function count(array $container): int
    {
        return count($container);
    }

    public static function last(array $container) // : mixed
    {
        return count($container) ? end($container) : null;
    }

    public static function is_empty(array $container): bool
    {
        return static::count($container) === 0;
    }

    /**
     * Returns the first and only element of the given Traversable, or throws if the
     * Traversable is empty or contains more than one element.
     *
     * An optional format string (and format arguments) may be passed to specify
     * a custom message for the exception in the error case.
     *
     * For Traversables with more than one element, see `C::firstx`.
     *
     * @param array $container
     * @param string|null $format_string
     * @param mixed ...$format_args
     * @return mixed
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    public static function onlyx(array $container, ?string $format_string = null, ...$format_args) // : mixed
    {
        $first = true;
        $result = null;

        foreach ($container as $value) {
            invariant(
                $first,
                '%s',
                $format_string === null
                    ? Str::format('Expected exactly one element but got %d.', static::count($container))
                    : vsprintf($format_string, $format_args),
            );

            $result = $value;
            $first = false;
        }

        invariant(
            $first === false,
            '%s',
            $format_string === null
                ? 'Expected non-empty Traversable.'
                : vsprintf($format_string, $format_args),
        );

        /* HH_FIXME[4110] $first is false implies $result is set to T */
        return $result;
    }
}

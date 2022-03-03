<?php

namespace Zheltikov\Xhp\Html;

use IntlChar;
use Zheltikov\Memoize;

class EntityHelper
{
    use Memoize\Helper;

    public function checkEntity(string $entity): ?string
    {
        /** @var callable[] $fn */
        static $fn = [];

        return static::memoizeLSB(
            static::class,
            $fn,
            function (string $entity): ?string {
                // Named character references
                // Decimal numeric character reference
                // Hexadecimal numeric character reference
                return $this->checkNamedCharRef($entity)
                    ?? $this->checkDecNumericCharRef($entity)
                    ?? $this->checkHexNumericCharRef($entity);
            },
            $entity,
        );
    }

    public function checkNamedCharRef(string $entity): ?string
    {
        $list = NamedEntityList::getList();

        if (!array_key_exists($entity, $list)) {
            return null;
        }

        $char = $list[$entity]['characters'];
        return $this->checkSpecialChar($char) ?? $char;
    }

    public function checkSpecialChar(string $char): ?string
    {
        $specialChars = get_html_translation_table(HTML_SPECIALCHARS);
        return array_key_exists($char, $specialChars)
            ? $specialChars[$char] : null;
    }

    public function checkDecNumericCharRef(string $entity): ?string
    {
        $pattern = /** @lang RegExp */
            "/^&#([0-9]+);$/uUS";
        $matches = [];

        if (!preg_match($pattern, $entity, $matches)) {
            return null;
        }

        $char = IntlChar::chr($matches[1]);
        return $this->checkSpecialChar($char) ?? $char;
    }

    public function checkHexNumericCharRef(string $entity): ?string
    {
        $pattern = /** @lang RegExp */
            "/^&#[xX]([0-9a-fA-F]+);$/uUS";
        $matches = [];

        if (!preg_match($pattern, $entity, $matches)) {
            return null;
        }

        $char = IntlChar::chr(hexdec($matches[1]));
        return $this->checkSpecialChar($char) ?? $char;
    }
}

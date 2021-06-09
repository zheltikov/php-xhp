<?php

namespace Zheltikov\PhpXhp\Reflection;

class ReflectionXHPAttribute
{
    private \Zheltikov\PhpXhp\Reflection\XHPAttributeType $type;

    /**
     * OBJECT: string (class name)
     * ENUM: array<string> (enum values)
     * ARRAY: Array decl
     * @var mixed
     */
    private $extraType;

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * @var bool
     */
    private bool $required;

    /**
     * @var array
     * keyset<string>
     */
    private static $specialAttributes = ['data', 'aria'];

    private string $name;

    public function __construct(string $name, array $decl)
    {
        $this->name = $name;
        $this->type = \Zheltikov\PhpXhp\Reflection\XHPAttributeType::from($decl[0]);
        $this->extraType = $decl[1];
        $this->defaultValue = $decl[2];
        $this->required = (bool) $decl[3];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValueType(): \Zheltikov\PhpXhp\Reflection\XHPAttributeType
    {
        return $this->type;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function hasDefaultValue(): bool
    {
        return $this->defaultValue !== null;
    }

    public function getDefaultValue() // : mixed
    {
        return $this->defaultValue;
    }

    // <<__Memoize>>
    public function getValueClass(): string
    {
        $t = $this->getValueType();
        \Zheltikov\PhpXhp\Lib\Assert::invariant(
            $t === \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_OBJECT(),
            'Tried to get value class for attribute %s of type %s - needed ' . 'OBJECT',
            $this->getName(),
            \array_flip(XHPAttributeType::toArray())[$t->getValue()],
        );
        $v = $this->extraType;
        \Zheltikov\PhpXhp\Lib\Assert::invariant(
            \is_string($v),
            'Class name for attribute %s is not a string',
            $this->getName(),
        );
        return $v;
    }

    // <<__Memoize>>
    // keyset<string>
    public function getEnumValues(): array
    {
        $t = $this->getValueType();
        \Zheltikov\PhpXhp\Lib\Assert::invariant(
            $t === \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_ENUM(),
            'Tried to get enum values for attribute %s of type %s - needed ' . 'ENUM',
            $this->getName(),
            \array_flip(XHPAttributeType::toArray())[$t->getValue()],
        );
        $v = $this->extraType;
        \Zheltikov\PhpXhp\Lib\Assert::invariant(
            \is_iterable($v),
            'Class name for attribute %s is not an array',
            $this->getName(),
        );
        return \array_keys(/* HH_FIXME[4110] not limited to arraykey */ $v);
    }

    /**
     * Returns true if the attribute is a data- or aria- attribute.
     */
    // <<__Memoize>>
    public static function isSpecial(string $attr): bool
    {
        return \Zheltikov\PhpXhp\Core\Str::length($attr) >= 6
               && $attr[4] === '-'
               && \Zheltikov\PhpXhp\Lib\C::contains_key(
                self::$specialAttributes,
                \Zheltikov\PhpXhp\Core\Str::slice($attr, 0, 4)
            );
    }

    public function __toString(): string
    {
        switch ($this->getValueType()) {
            case \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_STRING():
                $out = 'string';
                break;
            case \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_BOOL():
                $out = 'bool';
                break;
            case \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_INTEGER():
                $out = 'int';
                break;
            case \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_ARRAY():
                $out = 'array';
                break;
            case \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_OBJECT():
                $out = $this->getValueClass();
                break;
            case \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_VAR():
                $out = 'mixed';
                break;
            case \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_ENUM():
                $out = 'enum {';
                $out .= \Zheltikov\PhpXhp\Core\Str::join(
                    \Zheltikov\PhpXhp\Core\Vec::map(
                        $this->getEnumValues(),
                        function ($x) {
                            return "'" . $x . "'";
                        }
                    ),
                    ', ',
                );
                $out .= '}';
                break;
            case \Zheltikov\PhpXhp\Reflection\XHPAttributeType::TYPE_FLOAT():
                $out = 'float';
                break;
        }
        $out .= ' ' . $this->getName();
        if ($this->hasDefaultValue()) {
            $out .= ' = ' . \var_export($this->getDefaultValue(), true);
        }
        if ($this->isRequired()) {
            $out .= ' @required';
        }
        return $out;
    }
}

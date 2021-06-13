<?php

namespace Zheltikov\PhpXhp\Reflection;

use Zheltikov\PhpXhp\Lib\Assert;
use Zheltikov\PhpXhp\Lib\C;
use Zheltikov\PhpXhp\Lib\Str;
use Zheltikov\PhpXhp\Lib\Vec;

class ReflectionXHPAttribute
{
    /**
     * @var \Zheltikov\PhpXhp\Reflection\XHPAttributeType
     */
    private $type;

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
    private $required;

    /**
     * @var array
     * keyset<string>
     */
    private static $specialAttributes = ['data', 'aria'];

    /**
     * @var string
     */
    private $name;

    public function __construct(string $name, array $decl)
    {
        $this->name = $name;
        $this->type = XHPAttributeType::from($decl[0]);
        $this->extraType = $decl[1];
        $this->defaultValue = $decl[2];
        $this->required = (bool) $decl[3];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValueType(): XHPAttributeType
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
        Assert::invariant(
            $t === XHPAttributeType::TYPE_OBJECT(),
            'Tried to get value class for attribute %s of type %s - needed ' . 'OBJECT',
            $this->getName(),
            \array_flip(XHPAttributeType::toArray())[$t->getValue()],
        );
        $v = $this->extraType;
        Assert::invariant(
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
        Assert::invariant(
            $t === XHPAttributeType::TYPE_ENUM(),
            'Tried to get enum values for attribute %s of type %s - needed ' . 'ENUM',
            $this->getName(),
            \array_flip(XHPAttributeType::toArray())[$t->getValue()],
        );
        $v = $this->extraType;
        Assert::invariant(
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
        return Str::length($attr) >= 6
               && $attr[4] === '-'
               && C::contains_key(
                self::$specialAttributes,
                Str::slice($attr, 0, 4)
            );
    }

    public function __toString(): string
    {
        $out = '';
        switch ($this->getValueType()) {
            case XHPAttributeType::TYPE_STRING():
                $out = 'string';
                break;
            case XHPAttributeType::TYPE_BOOL():
                $out = 'bool';
                break;
            case XHPAttributeType::TYPE_INTEGER():
                $out = 'int';
                break;
            case XHPAttributeType::TYPE_ARRAY():
                $out = 'array';
                break;
            case XHPAttributeType::TYPE_OBJECT():
                $out = $this->getValueClass();
                break;
            case XHPAttributeType::TYPE_VAR():
                $out = 'mixed';
                break;
            case XHPAttributeType::TYPE_ENUM():
                $out = 'enum {';
                $out .= Str::join(
                    Vec::map(
                        $this->getEnumValues(),
                        function ($x) {
                            return "'" . $x . "'";
                        }
                    ),
                    ', ',
                );
                $out .= '}';
                break;
            case XHPAttributeType::TYPE_FLOAT():
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

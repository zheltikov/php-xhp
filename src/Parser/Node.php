<?php

namespace Zheltikov\Xhp\Parser;

use JsonSerializable;

class Node implements JsonSerializable
{
    /**
     * @var Type
     */
    protected Type $type;

    /**
     * @var \Zheltikov\Xhp\Parser\Node[]
     */
    protected array $children;

    /**
     * @var \Zheltikov\Xhp\Parser\Node|null
     */
    protected ?Node $parent;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param \Zheltikov\Xhp\Parser\Type|null $type
     * @param null $value
     */
    public function __construct(?Type $type = null, $value = null)
    {
        $this->setType($type)
            ->setValue($value);
        $this->children = [];
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Node|null $child
     * @return $this
     */
    public function appendChild(?Node $child = null): self
    {
        if ($child !== null) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Node|null $child
     * @return $this
     */
    public function prependChild(?Node $child = null): self
    {
        if ($child !== null) {
            array_unshift($this->children, $child);
            $child->setParent($this);
        }

        return $this;
    }

    /**
     * @param iterable|null $children
     * @return $this
     */
    public function appendChildren(?iterable $children = null): self
    {
        if ($children !== null) {
            foreach ($children as $child) {
                $this->appendChild($child);
            }
        }

        return $this;
    }

    /**
     * @return \Zheltikov\Xhp\Parser\Node[]
     */
    public function &getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Node|null $parent
     * @return $this
     */
    public function setParent(?Node $parent = null): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return \Zheltikov\Xhp\Parser\Node|null
     */
    public function &getParent(): ?Node
    {
        return $this->parent;
    }

    /**
     * @param int $index
     * @return \Zheltikov\Xhp\Parser\Node|null
     */
    public function &getChildAt(int $index): ?Node
    {
        $i = 0;
        foreach ($this->getChildren() as &$child) {
            if ($index === $i) {
                return $child;
            }
            $i++;
        }
        unset($child);

        $child = null;
        return $child;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = [
            'type' => $this->getType()->getKey(),
        ];

        if ($this->getValue() !== null) {
            $data['value'] = $this->getValue();
            // $data['__value__gettype'] = gettype($this->getValue());
        }

        if ($this->hasChildren()) {
            $data['children'] = $this->getChildren();
        }

        return $data;
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Type $type
     * @return \Zheltikov\Xhp\Parser\Node|null
     */
    public function &getFirstByType(Type $type): ?Node
    {
        /** @var \Zheltikov\Xhp\Parser\Node $child */
        foreach ($this->children as &$child) {
            if ($child->getType()->equals($type)) {
                return $child;
            }

            if ($child->hasChildren()) {
                $result =& $child->getFirstByType($type);
                if ($result !== null) {
                    return $result;
                }
            }
        }

        $result = null;
        return $result;
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Type $type
     * @return \Generator
     */
    public function &streamDeepByType(Type $type): \Generator
    {
        /** @var \Zheltikov\Xhp\Parser\Node $child */
        foreach ($this->children as &$child) {
            if ($child->getType()->equals($type)) {
                yield $child;
            }

            if ($child->hasChildren()) {
                $result = $child->streamDeepByType($type);
                foreach ($result as &$value) {
                    yield $value;
                }
            }
        }
    }

    /**
     * @return \Zheltikov\Xhp\Parser\Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Type|null $type
     * @return $this
     */
    public function setType(?Type $type = null): self
    {
        if ($type !== null) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Type $type
     * @return bool
     */
    public function hasChildOfType(Type $type): bool
    {
        foreach ($this->children as $child) {
            if ($child->getType()->equals($type)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Node $child
     * @return $this
     */
    public function deleteChild(Node $child): self
    {
        $unset_parent = false;
        $new_children = [];

        foreach ($this->children as $_child) {
            if ($child !== $_child) {
                $new_children[] = $_child;
            } else {
                $unset_parent = true;
            }
        }

        if ($unset_parent) {
            $child->setParent(null);
        }

        $this->children = $new_children;

        return $this;
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Node $child
     * @param \Zheltikov\Xhp\Parser\Node $new_child
     * @return $this
     */
    public function replaceChild(Node $child, Node $new_child): self
    {
        $unset_parent = false;
        $new_children = [];

        foreach ($this->children as $_child) {
            if ($child !== $_child) {
                $new_children[] = $_child;
            } else {
                $new_children[] = $new_child;
                $new_child->setParent($this);
                $unset_parent = true;
            }
        }

        if ($unset_parent) {
            $child->setParent(null);
        }

        $this->children = $new_children;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return $this->countChildren() > 0;
    }

    /**
     * @return int
     */
    public function countChildren(): int
    {
        return count($this->children);
    }

    /**
     * @return string
     */
    public function pretty(): string
    {
        $result = $this->type->getValue();

        if ($this->value !== null) {
            $result .= '(' . ((string) $this->value) . ')';
        }

        $child_count = $this->countChildren();
        if ($child_count > 0) {
            $result .= '<' . "\n";

            foreach ($this->children as $index => $child) {
                $result .= implode(
                    "\n",
                    array_map(
                        function (string $line): string {
                            return "\t" . $line;
                        },
                        explode("\n", $child->pretty())
                    )
                );

                if ($index + 1 < $child_count) {
                    $result .= ', ' . "\n";
                }
            }

            $result .= "\n" . '>';
        }

        return $result;
    }

    /**
     * @return string
     */
    public function prettyHtml(): string
    {
        return htmlspecialchars($this->pretty());
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function getFromValue(string $key, $default = null)
    {
        if (array_key_exists($key, $this->getValue())) {
            return $this->getValue()[$key];
        }
        return $default;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param iterable|null $children
     * @return $this
     */
    public function prependChildren(?iterable $children = null): self
    {
        if ($children !== null) {
            foreach ($children as $child) {
                $this->prependChild($child);
            }
        }

        return $this;
    }

    /**
     * @return \Zheltikov\Xhp\Parser\Node|null
     */
    public function &nextSibling(): ?Node
    {
        $next_sibling = null;

        if ($this->getParent() === null) {
            return $next_sibling;
        }

        $siblings = $this->getParent()->getChildren();
        $take_next = false;

        foreach ($siblings as $sibling) {
            if ($take_next) {
                $next_sibling = $sibling;
                break;
            }

            if ($sibling === $this) {
                $take_next = true;
            }
        }

        return $next_sibling;
    }
}

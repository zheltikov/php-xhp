<?php

namespace Zheltikov\Xhp\Parser;

use Zheltikov\Xhp\Core\Frag;
use Zheltikov\Xhp\Core\XHPChild;
use Zheltikov\Xhp\Html\TagMap;

use function Zheltikov\Invariant\invariant;
use function Zheltikov\Invariant\invariant_violation;

/**
 *
 */
class Converter
{
    /**
     * @var \Zheltikov\Xhp\Parser\Node
     */
    protected Node $root_node;

    /**
     * @var \Zheltikov\Xhp\Core\XHPChild
     */
    protected XHPChild $result;

    /**
     * @param \Zheltikov\Xhp\Parser\Node|null $root_node
     */
    public function __construct(?Node $root_node = null)
    {
        $this->setRootNode($root_node);
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Node|null $root_node
     * @return $this
     */
    public function setRootNode(?Node $root_node = null): self
    {
        if ($root_node !== null) {
            $this->root_node = $root_node;
        }

        return $this;
    }

    /**
     * @return \Zheltikov\Xhp\Parser\Node
     */
    public function getRootNode(): Node
    {
        return $this->root_node;
    }

    /**
     * @return \Zheltikov\Xhp\Core\XHPChild
     */
    public function getResult(): XHPChild
    {
        return $this->result;
    }

    /**
     *
     */
    public function execute(): void
    {
        $this->result = $this->convertNode($this->getRootNode());
    }

    /**
     * @param \Zheltikov\Xhp\Parser\Node $node
     * @return \Zheltikov\Xhp\Core\XHPChild
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    public function convertNode(Node $node): XHPChild
    {
        $tag_name_node = $node->getChildAt(0);
        invariant(
            $tag_name_node->getType()->equals(Type::XHP_TAG_NAME()),
            'Node must have type XHP_TAG_NAME.'
        );

        $tag_name = $tag_name_node->getValue();
        $class_name = $this->getClassNameForTagName($tag_name);

        invariant($class_name !== null, 'Class not found for tag: %s', $tag_name);

        $tag_body_node = $node->getChildAt(1);
        invariant(
            $tag_body_node->getType()->equals(Type::XHP_TAG_BODY()),
            'Node must have type XHP_TAG_BODY.'
        );

        /** @var \Zheltikov\Xhp\Parser\Node|null $attributes_node */
        $attributes_node = $tag_body_node->getFromValue('attributes');
        invariant(
            $attributes_node !== null
            && $attributes_node->getType()->equals(Type::ATTRIBUTES()),
            'Node must have type ATTRIBUTES.'
        );

        $attributes = [];
        foreach ($attributes_node->getChildren() as $attr) {
            invariant(
                $attr->getType()->equals(Type::ATTRIBUTE()),
                'Node must have type ATTRIBUTE.'
            );

            $name = $attr->getFromValue('name');
            invariant(is_string($name), 'Attribute name must be a string.');
            $value = $attr->getFromValue('value');
            $attributes[$name] = $value;
        }

        $children = [];
        if ($tag_body_node->countChildren()) {
            $child_list_node = $tag_body_node->getChildAt(0);
            invariant(
                $child_list_node->getType()->equals(Type::CHILD_LIST()),
                'Node must have type CHILD_LIST.'
            );
            foreach ($child_list_node->getChildren() as $child) {
                if (
                    $child->getType()->equals(Type::WHITESPACE())
                    || $child->getType()->equals(Type::XHP_TEXT())
                    || $child->getType()->equals(Type::XHP_ENTITY())
                    || $child->getType()->equals(Type::INJECTED())
                ) {
                    $children[] = $child->getValue();
                    continue;
                }

                if ($child->getType()->equals(Type::XHP_TAG())) {
                    $children[] = $this->convertNode($child);
                    continue;
                }

                invariant_violation('Child Node has unknown type: %s', $child->getType());
            }
        }

        $filename = (string) $node
            ->getFromValue('filename', 'unknown');
        $line = (int) $node
            ->getFromValue('line', -1);

        return new $class_name($attributes, $children, $filename, $line);
    }

    /**
     * @param string $tag_name
     * @return string|null
     */
    protected function getClassNameForTagName(string $tag_name): ?string
    {
        $map = TagMap::getTagMap();
        if (array_key_exists($tag_name, $map)) {
            return $map[$tag_name];
        }
        return null;
    }
}

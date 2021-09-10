<?php

namespace Zheltikov\Xhp\Parser;

class Optimizer
{
    /**
     * @var \Zheltikov\Xhp\Parser\Node
     */
    protected Node $root_node;

    /**
     * @var bool
     */
    protected bool $debug = false;

    /**
     * @param \Zheltikov\Xhp\Parser\Node|null $root_node
     * @param bool $debug
     */
    public function __construct(?Node $root_node = null, bool $debug = false)
    {
        if ($root_node !== null) {
            $this->setRootNode($root_node);
        }
        $this->debug = $debug;
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

    public function execute(): void
    {
        // return;

        $serialize = function () {
            return $this->isDebug()
                ? $this->root_node->pretty()
                : json_encode($this->root_node);
        };

        if ($this->isDebug()) {
            echo 'Unoptimized: ', $serialize(), "\n";
        }

        $serialized = '';
        $i = 0;

        while ($serialized !== $serialize()) {
            $serialized = $serialize();

            // TODO: add correct handling of child-less Nodes, but with a value set

            $this->joinXhpTexts();
            $this->convertWhitespaceToXhpText();

            if ($this->isDebug()) {
                echo 'Optimized:   ', $serialize(), "\n";
            }

            $i++;
        }

        if ($this->isDebug()) {
            echo $i, " optimization iterations.\n";
        }
    }

    // -------------------------------------------------------------------------

    /**
     *
     */
    protected function joinXhpTexts(): void
    {
        $nodes = $this->root_node->streamDeepByType(Type::XHP_TEXT());

        foreach ($nodes as &$node) {
            $parent =& $node->getParent();
            $next_sibling =& $node->nextSibling();

            if ($next_sibling !== null) {
                if ($next_sibling->getType()->equals(Type::XHP_TEXT())) {
                    $node->setValue($node->getValue() . $next_sibling->getValue());
                    $parent->deleteChild($next_sibling);
                }
            }
        }
    }

    /**
     *
     */
    protected function convertWhitespaceToXhpText(): void
    {
        $nodes = $this->root_node->streamDeepByType(Type::WHITESPACE());

        foreach ($nodes as &$node) {
            $parent =& $node->getParent();
            $new_node = new Node(Type::XHP_TEXT(), $node->getValue());
            $parent->replaceChild($node, $new_node);
            unset($node);
        }
    }

    // -------------------------------------------------------------------------

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return $this
     */
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }
}

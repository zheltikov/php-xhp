<?php

namespace Zheltikov\PhpXhp\Core;

abstract class Primitive extends Node
{
    abstract protected function stringify(): string;

    /**
     * @throws UseAfterRenderException
     */
    // <<__Override>>
    final public function toString(): string
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException('Attempted to render XHP element twice');
        }

        $that = $this->__flushSubtree();
        $result = $that->stringify();
        $this->__isRendered = true;
        return $result;
    }

    final private function __flushElementChildren(): void
    {
        $children = $this->getChildren();
        $awaitables = [];
        foreach ($children as $idx => $child) {
            if ($child instanceof Node) {
                $child->__transferContext($this->getAllContexts());
                $awaitables[$idx] = $child->__flushSubtree();
            }
        }
        if ($awaitables) {
            // FIXME: this may cause a memory leak
            $awaited = $awaitables; // await Dict\from_async($awaitables);
            foreach ($awaited as $idx => $child) {
                $children[$idx] = $child;
            }
        }
        if ($this->__isRendered) {
            throw new UseAfterRenderException('Attempted to render XHP element twice');
        }
        $this->replaceChildren($children);
    }

    // <<__Override>>
    final protected function __flushSubtree(): Primitive
    {
        try {
            $this->__flushElementChildren();
        } catch (UseAfterRenderException $e) {
            $e->__viaXHPPath(static::class);
            throw $e;
        }
        if (ChildValidation::is_enabled()) {
            $this->validateChildren();
        }
        return $this;
    }
}

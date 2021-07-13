<?php

namespace Zheltikov\PhpXhp\Core;

use Zheltikov\PhpXhp\Exceptions\CoreRenderException;

/**
 * element defines an interface that all user-land elements should subclass
 * from. The main difference between element and primitive is that
 * subclasses of element should implement `render()` instead of `stringify`.
 * This is important because most elements should not be dealing with strings
 * of markup.
 */
abstract class Element extends Node
{
    abstract protected function render(): Node;

    /**
     * @return string
     * @throws \Zheltikov\PhpXhp\Exceptions\CoreRenderException
     * @throws \Zheltikov\PhpXhp\Exceptions\InvalidChildrenException
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    final public function toString(): string
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException('Attempted to render XHP element twice');
        }

        try {
            $that = $this->__flushRenderedRootElement();

            return $that->toString();
        } catch (UseAfterRenderException $e) {
            $e->__viaXHPPath(static::class);
            throw $e;
        }
    }

    /**
     * @return \Zheltikov\PhpXhp\Core\Primitive
     * @throws \Zheltikov\PhpXhp\Exceptions\CoreRenderException
     * @throws \Zheltikov\PhpXhp\Exceptions\InvalidChildrenException
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    final protected function __flushSubtree(): Primitive
    {
        try {
            $that = $this->__flushRenderedRootElement();

            return $that->__flushSubtree();
        } catch (UseAfterRenderException $e) {
            $e->__viaXHPPath(static::class);
            throw $e;
        }
    }

    /**
     * @throws UseAfterRenderException
     * @throws \Zheltikov\PhpXhp\Exceptions\InvalidChildrenException
     */
    protected function __renderAndProcess(): Node
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException('Attempted to render XHP element twice');
        }

        if (ChildValidation::is_enabled()) {
            $this->validateChildren();
        }

        $composed = $this->render();
        $composed->__transferContext($this->getAllContexts());
        $this->__isRendered = true;

        return $composed;
    }

    /**
     * @throws UseAfterRenderException
     * @throws \Zheltikov\PhpXhp\Exceptions\CoreRenderException
     * @throws \Zheltikov\PhpXhp\Exceptions\InvalidChildrenException
     */
    final protected function __flushRenderedRootElement(): Primitive
    {
        $that = $this;

        // Flush root elements returned from render() to an primitive
        while ($that instanceof Element) {
            $that = $that->__renderAndProcess();
        }

        if ($that instanceof Primitive) {
            return $that;
        }

        // render() must always (eventually) return primitive
        throw new CoreRenderException($this, $that);
    }
}

<?php

namespace Zheltikov\PhpXhp\Core;

// use namespace Facebook\XHP\HTML;

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
     * @throws UseAfterRenderException
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
     * @throws UseAfterRenderException
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
     */
    protected function __renderAndProcess(): Node
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException('Attempted to render XHP element twice');
        }

        // FIXME: mimic this somehow
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
     */
    final protected function __flushRenderedRootElement(): Primitive
    {
        $that = $this;

        // Flush root elements returned from render() to an primitive
        // FIXME: this may not be correct
        while ($that instanceof Element) {
            $that = $that->__renderAndProcess();
        }

        // FIXME: this may not be correct
        if ($that instanceof Primitive) {
            return $that;
        }

        // render() must always (eventually) return primitive
        // FIXME: mimic this
        throw new \Facebook\XHP\CoreRenderException($this, $that);
    }
}

<?php

namespace Zheltikov\Xhp\Html;

use Zheltikov\Xhp\Core\UnsafeRenderable;
use Zheltikov\Xhp\Exceptions\ClassException;

/**
 * For details about the implementation, see:
 * https://html.spec.whatwg.org/multipage/syntax.html#character-references
 */
final class Entity extends PCDataElement implements UnsafeRenderable
{
    /**
     * @var string
     */
    private $entityAsHtml = '';

    /**
     * @throws ClassException
     */
    protected function init(): void
    {
        if (count($this->getAttributes()) > 0) {
            throw new ClassException($this, 'This class does not support attributes');
        }

        $entity = null;
        foreach ($this->getChildren() as $child) {
            if ($entity !== null) {
                throw new ClassException($this, 'You must supply only one entity string');
            }

            $entity = $child;
        }

        if ($entity === null) {
            throw new ClassException($this, 'You must supply a string identifying an entity as child');
        }

        $html = (new EntityHelper())
            ->checkEntity($entity);
        if ($html !== null) {
            $this->entityAsHtml = $html;
            return;
        }

        throw new ClassException(
            $this,
            'Invalid entity string supplied! Supported example formats include: `&copy;`, `&#8212;` or `&#x2014;`.'
        );
    }

    protected function stringify(): string
    {
        return $this->entityAsHtml;
    }

    final public function toHTMLString(): string
    {
        return $this->entityAsHtml;
    }
}

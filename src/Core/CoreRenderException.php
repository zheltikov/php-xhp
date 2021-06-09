<?php

namespace Zheltikov\PhpXhp\Core;

class CoreRenderException extends Exception
{
    /**
     * CoreRenderException constructor.
     * @param \Zheltikov\PhpXhp\Core\Node $that
     * @param mixed $rend
     */
    public function __construct(Node $that, $rend)
    {
        $message = ':x:element::render must reduce an object to an :x:primitive, but `';
        $message .= \get_class($that) . '` reduced into `' . \gettype($rend) . "`.\n\n";
        $message .= $that->source;

        parent::__construct($message);
    }
}

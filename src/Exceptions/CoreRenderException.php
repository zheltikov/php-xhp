<?php

namespace Zheltikov\PhpXhp\Exceptions;

use Zheltikov\PhpXhp\Core\Node;

class CoreRenderException extends Exception
{
    /**
     * CoreRenderException constructor.
     * @param Node $that
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

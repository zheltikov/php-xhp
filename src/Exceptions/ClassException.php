<?php

namespace Zheltikov\PhpXhp\Exceptions;

use Zheltikov\PhpXhp\Core\Node;

class ClassException extends Exception
{
    public function __construct(Node $that, string $msg)
    {
        $message = 'Exception in class `' . self::getElementName($that) . "`\n\n";
        $message .= $that->source . "\n\n";
        $message .= $msg;

        parent::__construct($message);
    }
}

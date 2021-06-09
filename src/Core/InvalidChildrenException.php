<?php

namespace Zheltikov\PhpXhp\Core;

class InvalidChildrenException extends Exception
{
    public function __construct(Node $that, int $index)
    {
        $message = 'Element `' . self::getElementName($that) . "` was rendered with invalid children.\n\n";
        $message .= $that->source . "\n\n";
        $message .= 'Verified ' . $index . " children before failing.\n\n";
        $message .= "Children expected:\n" . $that->__getChildrenDeclaration() . "\n\n";
        $message .= "Children received:\n" . $that->__getChildrenDescription();

        parent::__construct($message);
    }
}

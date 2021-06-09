<?php

namespace Zheltikov\PhpXhp\Core;

class Exception extends \Exception
{
    protected static function getElementName(Node $that): string
    {
        return \get_class($that);
    }
}

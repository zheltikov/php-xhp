<?php

namespace Zheltikov\PhpXhp\Exceptions;

use Zheltikov\PhpXhp\Core\Node;

class Exception extends \Exception
{
    protected static function getElementName(Node $that): string
    {
        return \get_class($that);
    }
}

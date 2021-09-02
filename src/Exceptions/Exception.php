<?php

namespace Zheltikov\Xhp\Exceptions;

use Zheltikov\Xhp\Core\Node;

class Exception extends \Exception
{
    protected static function getElementName(Node $that): string
    {
        return get_class($that);
    }
}

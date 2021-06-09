<?php

namespace Zheltikov\PhpXhp\Exceptions;

use Zheltikov\PhpXhp\Exceptions\Exception;
use Zheltikov\PhpXhp\Core\Node;

class AttributeNotSupportedException extends Exception
{
    public function __construct(Node $that, string $attr)
    {
        $message = 'Attribute "' . $attr . '" is not supported in class ';
        $message .= '"' . self::getElementName($that) . '"' . "\n\n";
        $message .= $that->source . "\n\n";
        $message .= 'Please check for typos in your attribute. If you are creating a new ';
        $message .= 'attribute on this element define it with the "attribute" keyword' . "\n\n";

        parent::__construct($message);
    }
}

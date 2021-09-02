<?php

namespace Zheltikov\Xhp\Exceptions;

use Zheltikov\Xhp\Core\Node;

class AttributeRequiredException extends Exception
{
    public function __construct(Node $that, string $attr)
    {
        $message = 'Required attribute `' . $attr . '` was not specified in element `';
        $message .= self::getElementName($that) . "`.\n\n";
        $message .= $that->source;

        parent::__construct($message);
    }
}

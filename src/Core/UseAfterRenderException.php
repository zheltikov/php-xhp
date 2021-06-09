<?php

namespace Zheltikov\PhpXhp\Core;

// FIXME: extends \InvalidOperationException
use Zheltikov\PhpXhp\Lib\Assert;

final class UseAfterRenderException extends \RuntimeException
{
    /**
     * @var array
     * vec<classname<Node>>
     */
    private array $xhpPath = [];

    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * @param string $node (classname<Node>)
     * @throws \Exception
     */
    public function __viaXHPPath(string $node): void
    {
        Assert::invariant(\class_exists($node), 'Node class name must exist');
        Assert::invariant(\in_array(Node::class, \class_parents($node)), 'Node class name must extend Node');
        $this->xhpPath[] = $node;

        // FIXME: this is a quick workaround
        $this->message = $this->getXhpMessage();
    }

    // <<__Override>>
    public function getXhpMessage(): string
    {
        if (C::is_empty($this->xhpPath)) {
            return $this->message;
        }

        $message = $this->message;
        $message .= "\nVia XHPPath: ";
        $message .= Str::join(
            Vec::map(
                Vec::reverse($this->xhpPath),
                function ($class) {
                    return Str::strip_prefix($class, 'Zheltikov\\PhpXhp\\');
                }
            ),
            ' -> '
        );
        $message .= '.';

        return $message;
    }
}

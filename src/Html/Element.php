<?php

namespace Zheltikov\PhpXhp\Html;

use Zheltikov\PhpXhp\Core\Primitive;
use Zheltikov\PhpXhp\Core\Str;
use Zheltikov\PhpXhp\Core\Vec;

abstract class Element extends Primitive
{
    use XHPHTMLHelpers;

    protected string $tagName = '';

    protected final function renderBaseAttrs(): string
    {
        $buf = '<' . $this->tagName;
        foreach ($this->getAttributes() as $key => $val) {
            if ($val !== null && $val !== false) {
                if ($val === true) {
                    $buf .= ' ' . \htmlspecialchars($key);
                } else {
                    // TODO: mimic class
                    if ($val instanceof \Facebook\XHP\UnsafeAttributeValue_DEPRECATED) {
                        $val_str = $val->toHTMLString();
                    } else {
                        $val_str = \htmlspecialchars((string) $val, \ENT_COMPAT);
                    }

                    $buf .= ' ' . \htmlspecialchars($key) . '="' . $val_str . '"';
                }
            }
        }
        return $buf;
    }

    // <<__Override>>
    protected function stringify(): string
    {
        $buf = $this->renderBaseAttrs() . '>';
        $buf .= Str::join(
            Vec::map(
                $this->getChildren(),
                function ($child) {
                    return self::renderChild($child);
                }
            ),
            ''
        );
        $buf .= '</' . $this->tagName . '>';
        return $buf;
    }
}

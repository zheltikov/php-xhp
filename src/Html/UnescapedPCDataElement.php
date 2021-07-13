<?php

namespace Zheltikov\PhpXhp\Html;

use Zheltikov\PhpXhp\Core\UnsafeRenderable;
use Zheltikov\PhpXhp\Exceptions\ClassException;

/**
 * Subclasses of unescaped_pcdata_element must contain only string children.
 * However, the strings will not be escaped. This is intended for tags like
 * <script> or <style> whose content is interpreted literally by the browser.
 *
 * From section 6.2 of the HTML 4.01 spec: "Although the STYLE and SCRIPT
 * elements use CDATA for their data model, for these elements, CDATA must be
 * handled differently by user agents. Markup and entities must be treated as
 * raw text and passed to the application as is. The first occurrence of the
 * character sequence "</" (end-tag open delimiter) is treated as terminating
 * the end of the s content. In valid documents, this would be the end tag for
 * the element."
 */
// <<__Sealed(script::class, style::class) >>
abstract class UnescapedPCDataElement extends PCDataElement implements UnsafeRenderable
{
    // <<__Override>>
    protected function stringify(): string
    {
        $buf = $this->renderBaseAttrs() . '>';
        foreach ($this->getChildren() as $child) {
            if (!is_string($child)) {
                throw new ClassException($this, 'Child must be a string');
            }

            $buf .= $child;
        }
        $buf .= '</' . $this->tagName . '>';
        return $buf;
    }

    final public function toHTMLString(): string
    {
        return $this->stringify();
    }
}

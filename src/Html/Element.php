<?php

namespace Zheltikov\PhpXhp\Html;

use Zheltikov\PhpXhp\Core\Primitive;
use Zheltikov\PhpXhp\Core\Str;
use Zheltikov\PhpXhp\Core\Vec;
use Zheltikov\PhpXhp\Core\XHPAttributeType;

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

    // -------------------------------------------------------------------------

    protected static function __xhpAttributeDeclaration(): array
    {
        return [
            // Global HTML attributes
            'accesskey' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'autocapitalize' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'off', // identical to none
                    'none',
                    'on', // identical to sentences
                    'sentences',
                    'words',
                    'characters',
                ],
                null, // defaultValue
                false, // required
            ],
            'autofocus' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'class' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'contenteditable' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'true',
                    'false',
                ],
                null, // defaultValue
                false, // required
            ],
            'contextmenu' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'dir' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'auto',
                    'ltr',
                    'rtl',
                ],
                null, // defaultValue
                false, // required
            ],
            'draggable' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'true',
                    'false',
                ],
                null, // defaultValue
                false, // required
            ],
            'dropzone' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'enterkeyhint' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'enter',
                    'done',
                    'go',
                    'next',
                    'previous',
                    'search',
                    'send',
                ],
                null, // defaultValue
                false, // required
            ],
            'hidden' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'id' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'is' => [ // needs to be a name of a defined custom element
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'inert' => [
                XHPAttributeType::TYPE_BOOL()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'inputmode' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'decimal',
                    'email',
                    'full-width-latin',
                    'kana',
                    'katakana',
                    'latin',
                    'latin-name',
                    'latin-prose',
                    'none',
                    'numeric',
                    'search',
                    'tel',
                    'text',
                    'url',
                    'verbatim',
                ],
                null, // defaultValue
                false, // required
            ],
            'itemid' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'itemprop' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'itemref' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'itemscope' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'itemtype' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'lang' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'nonce' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'role' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'spellcheck' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'true',
                    'false',
                ],
                null, // defaultValue
                false, // required
            ],
            'style' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'tabindex' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'title' => [
                XHPAttributeType::TYPE_STRING()->getValue(), // type
                null, // extraType
                null, // defaultValue
                false, // required
            ],
            'translate' => [
                XHPAttributeType::TYPE_ENUM()->getValue(), // type
                [ // extraType
                    'yes',
                    'no',
                ],
                null, // defaultValue
                false, // required
            ],

            // Javascript events
            /*
            string onabort,
            string onauxclick,
            string onblur,
            string oncancel,
            string oncanplay,
            string oncanplaythrough,
            string onchange,
            string onclick,
            string onclose,
            string oncontextmenu,
            string oncopy,
            string oncuechange,
            string oncut,
            string ondblclick,
            string ondrag,
            string ondragend,
            string ondragenter,
            string ondragexit,
            string ondragleave,
            string ondragover,
            string ondragstart,
            string ondrop,
            string ondurationchange,
            string onemptied,
            string onended,
            string onerror,
            string onfocus,
            string onformdata,
            string oninput,
            string oninvalid,
            string onkeydown,
            string onkeypress,
            string onkeyup,
            string onload,
            string onloadeddata,
            string onloadedmetadata,
            string onloadstart,
            string onmousedown,
            string onmouseenter,
            string onmouseleave,
            string onmousemove,
            string onmouseout,
            string onmouseover,
            string onmouseup,
            string onmousewheel,
            string onpaste,
            string onpause,
            string onplay,
            string onplaying,
            string onprogress,
            string onratechange,
            string onreset,
            string onresize,
            string onscroll,
            string onsecuritypolicyviolation,
            string onseeked,
            string onseeking,
            string onselect,
            string onshow,
            string onslotchange,
            string onstalled,
            string onsubmit,
            string onsuspend,
            string ontimeupdate,
            string ontoggle,
            string onvolumechange,
            string onwaiting,
            string onwheel,
            */
        ];
    }
}

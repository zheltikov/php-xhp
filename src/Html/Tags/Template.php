<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Metadata;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;

final class Template extends Element implements Phrase, Metadata, Flow
{
    // The children declaration for this element is extraordinarily verbose so
    // I leave it to you to use it appropriately.

    /**
     * @var string
     */
    protected $tagName = 'template';
}

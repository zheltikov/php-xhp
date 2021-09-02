<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Metadata;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Element;

final class Template extends Element implements Phrase, Metadata, Flow
{
    // The children declaration for this element is extraordinarily verbose so
    // I leave it to you to use it appropriately.

    /**
     * @var string
     */
    protected $tagName = 'template';
}

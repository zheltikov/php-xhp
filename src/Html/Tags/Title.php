<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Metadata;
use Zheltikov\Xhp\Html\PCDataElement;

final class Title extends PCDataElement implements Metadata
{
    /**
     * @var string
     */
    protected $tagName = 'title';
}

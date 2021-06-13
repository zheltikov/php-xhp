<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Category\Metadata;
use Zheltikov\PhpXhp\Html\PCDataElement;

final class Title extends PCDataElement implements Metadata
{
    /**
     * @var string
     */
    protected $tagName = 'title';
}

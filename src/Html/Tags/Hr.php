<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Singleton;

final class Hr extends Singleton implements Flow
{
    /**
     * @var string
     */
    protected $tagName = 'hr';
}

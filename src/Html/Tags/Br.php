<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Singleton;

final class Br extends Singleton implements Phrase, Flow
{
    /**
     * @var string
     */
    protected $tagName = 'br';
}

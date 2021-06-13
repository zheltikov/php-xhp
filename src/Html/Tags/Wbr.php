<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Singleton;

final class Wbr extends Singleton implements Phrase, Flow
{
    /**
     * @var string
     */
    protected $tagName = 'wbr';
}

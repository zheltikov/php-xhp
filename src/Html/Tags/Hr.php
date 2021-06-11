<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Singleton;

final class Hr extends Singleton implements Flow
{
    protected string $tagName = 'hr';
}

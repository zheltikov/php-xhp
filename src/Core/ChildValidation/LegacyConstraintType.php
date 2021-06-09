<?php

namespace Zheltikov\PhpXhp\Core\ChildValidation;

use MyCLabs\Enum\Enum;

/**
 * Class LegacyConstraintType
 * @package Zheltikov\PhpXhp\Core\ChildValidation
 *
 * @extends Enum<LegacyConstraintType>
 *
 * @method LegacyConstraintType ANY()
 * @method LegacyConstraintType PCDATA()
 * @method LegacyConstraintType CLASSNAME()
 * @method LegacyConstraintType CATEGORY()
 * @method LegacyConstraintType EXPRESSION()
 */
class LegacyConstraintType extends Enum
{
    private const ANY = 1;
    private const PCDATA = 2;
    private const CLASSNAME = 3;
    private const CATEGORY = 4;
    private const EXPRESSION = 5;
}

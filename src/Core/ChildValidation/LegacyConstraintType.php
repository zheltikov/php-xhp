<?php

namespace Zheltikov\Xhp\Core\ChildValidation;

use MyCLabs\Enum\Enum;

/**
 * Class LegacyConstraintType
 * @package Zheltikov\Xhp\Core\ChildValidation
 *
 * @extends Enum<LegacyConstraintType>
 *
 * @method static LegacyConstraintType ANY()
 * @method static LegacyConstraintType PCDATA()
 * @method static LegacyConstraintType CLASSNAME()
 * @method static LegacyConstraintType CATEGORY()
 * @method static LegacyConstraintType EXPRESSION()
 */
class LegacyConstraintType extends Enum
{
    private const ANY = 1;
    private const PCDATA = 2;
    private const CLASSNAME = 3;
    private const CATEGORY = 4;
    private const EXPRESSION = 5;
}

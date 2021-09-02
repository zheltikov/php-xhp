<?php

namespace Zheltikov\Xhp\Html\Tags;

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Core\ChildValidation\Constraint;
use Zheltikov\Xhp\Core\ChildValidation\Validation;
use Zheltikov\Xhp\Html\Category\Flow;
use Zheltikov\Xhp\Html\Category\Phrase;
use Zheltikov\Xhp\Html\Element;

final class Ruby extends Element implements Phrase, Flow
{
    use Validation;

    protected static function getChildrenDeclaration(): Constraint
    {
        return ChildValidation::any_of(
            ChildValidation::at_least_one_of(
                ChildValidation::any_of(ChildValidation::pcdata(), ChildValidation::of_type(Rb::class)),
            ),
            ChildValidation::at_least_one_of(
                ChildValidation::any_of(
                    ChildValidation::sequence(
                        ChildValidation::of_type(Rp::class),
                        ChildValidation::of_type(Rt::class),
                    ),
                    ChildValidation::sequence(
                        ChildValidation::of_type(Rp::class),
                        ChildValidation::of_type(Rtc::class),
                    ),
                    ChildValidation::sequence(
                        ChildValidation::of_type(Rt::class),
                        ChildValidation::of_type(Rp::class),
                    ),
                    ChildValidation::sequence(
                        ChildValidation::of_type(Rtc::class),
                        ChildValidation::of_type(Rp::class),
                    ),
                )
            ),
        );
    }

    /**
     * @var string
     */
    protected $tagName = 'ruby';
}

<?php

namespace Zheltikov\PhpXhp\Html\Tags;

use Zheltikov\PhpXhp\Core\ChildValidation\Validation;
use Zheltikov\PhpXhp\Core\ChildValidation\Constraint;
use Zheltikov\PhpXhp\Core\ChildValidation;
use Zheltikov\PhpXhp\Html\Category\Flow;
use Zheltikov\PhpXhp\Html\Category\Phrase;
use Zheltikov\PhpXhp\Html\Element;

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

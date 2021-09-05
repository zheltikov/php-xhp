<?php

/* @generated */

namespace Zheltikov\Xhp\Parser;

/* This is an automatically GENERATED file, which should not be manually edited.
 * Instead edit one of the following:
 *  * the grammar files parser/xhp.y
 *  * the skeleton file parser/parser.template
 *  * the preprocessing script parser/rebuild_parser.php
 */
class Xhp extends ParserAbstract
{
    /** @var mixed */
    protected $semValue;

    protected int $tokenToSymbolMapSize = 269;
    protected int $actionTableSize = 12;
    protected int $gotoTableSize = 0;

    protected int $invalidSymbol = 14;
    protected int $errorSymbol = 1;
    protected int $defaultAction = -32766;
    protected int $unexpectedTokenRule = 32767;

    protected int $YY2TBLSTATE = 0;
    protected int $numNonLeafStates = 8;

    protected array $symbolToName = [
        "EOF",
        "error",
        "TOKEN_ANGLE_LEFT",
        "TOKEN_ANGLE_RIGHT",
        "TOKEN_FORWARD_SLASH",
        "TOKEN_TAG_NAME",
        "TOKEN_EOF",
        "TOKEN_NS_SEPARATOR",
        "TOKEN_WHITESPACE",
        "TOKEN_ERROR",
        "TOKEN_CURLY_START",
        "TOKEN_CURLY_END",
        "TOKEN_ELLIPSIS",
        "TOKEN_EQUALS"
    ];

    protected array $tokenToSymbol = [
            0,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,   14,   14,   14,   14,
           14,   14,   14,   14,   14,   14,    1,    6,    7,    8,
            9,    2,    3,    4,   10,   11,   12,   13,    5
    ];

    protected array $action = [
            4,   11,    0,    2,    1,    6,    0,   10,    0,    7,
            0,   12
    ];

    protected array $actionCheck = [
            3,    4,    0,    2,    5,    2,   -1,    3,   -1,    4,
           -1,    5
    ];

    protected array $actionBase = [
            1,   -3,   -1,    2,    3,    4,    5,    6
    ];

    protected array $actionDefault = [
        32767,32767,32767,32767,32767,32767,32767,32767
    ];

    protected array $goto = [
    ];

    protected array $gotoCheck = [
    ];

    protected array $gotoBase = [
            0,    0,    0,    0
    ];

    protected array $gotoDefault = [
        -32768,    3,    9,    5
    ];

    protected array $ruleToNonTerminal = [
            0,    1,    2,    3,    3
    ];

    protected array $ruleToLength = [
            1,    1,    4,    1,    4
    ];

    protected array $productions = [
        "\$start : root",
        "root : xhp_tag",
        "xhp_tag : TOKEN_ANGLE_LEFT TOKEN_TAG_NAME xhp_tag_body TOKEN_ANGLE_RIGHT",
        "xhp_tag_body : TOKEN_FORWARD_SLASH",
        "xhp_tag_body : TOKEN_ANGLE_RIGHT TOKEN_ANGLE_LEFT TOKEN_FORWARD_SLASH TOKEN_TAG_NAME"
    ];

    protected function initReduceCallbacks(): void
    {
        $this->reduceCallbacks = [
            0 => function ($stackPos) {
                $this->semValue = $this->semStack[$stackPos];
            },
            1 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            2 => function ($stackPos) {
                 $this->semValue = new XhpTag();
                                          $this->semValue->setName($this->semStack[$stackPos-(4-2)]);
                                          $this->semValue->setBody($this->semStack[$stackPos-(4-3)]);
            },
            3 => function ($stackPos) {
                 $this->semValue = new XhpTagBody();
                                          $this->semValue->setAttributes(null);
            },
            4 => function ($stackPos) {
                 $this->semValue = new XhpTagBody();
                                          $this->semValue->setAttributes(null);
                                          $this->semValue->setChildren(null);
                                          $this->semValue->setClosingTagName($this->semStack[$stackPos-(4-4)]);
            },
        ];
    }
}

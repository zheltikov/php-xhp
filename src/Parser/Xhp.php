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
    /** @var Node|null */
    protected ?Node $semValue;

    protected int $tokenToSymbolMapSize = 270;
    protected int $actionTableSize = 15;
    protected int $gotoTableSize = 4;

    protected int $invalidSymbol = 15;
    protected int $errorSymbol = 1;
    protected int $defaultAction = -32766;
    protected int $unexpectedTokenRule = 32767;

    protected int $YY2TBLSTATE = 4;
    protected int $numNonLeafStates = 13;

    protected array $symbolToName = [
        "EOF",
        "error",
        "TOKEN_WHITESPACE",
        "TOKEN_ANGLE_LEFT",
        "TOKEN_ANGLE_RIGHT",
        "TOKEN_FORWARD_SLASH",
        "TOKEN_TAG_NAME",
        "TOKEN_EOF",
        "TOKEN_NS_SEPARATOR",
        "TOKEN_ERROR",
        "TOKEN_CURLY_START",
        "TOKEN_CURLY_END",
        "TOKEN_ELLIPSIS",
        "TOKEN_EQUALS",
        "TOKEN_XHP_TEXT"
    ];

    protected array $tokenToSymbol = [
            0,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,   15,   15,   15,   15,
           15,   15,   15,   15,   15,   15,    1,    7,    8,    2,
            9,    3,    4,    5,   10,   11,   12,   13,    6,   14
    ];

    protected array $action = [
           21,    3,    0,   12,   16,   23,   22,    5,    9,    0,
           15,    0,   11,    0,   17
    ];

    protected array $actionCheck = [
            2,    3,    0,    4,    5,    2,    2,    6,    3,   -1,
            4,   -1,    5,   -1,    6
    ];

    protected array $actionBase = [
            3,   -2,   -1,    7,    3,    3,    5,    2,    4,    1,
            6,    8,    0,    0,    0,    0,    1
    ];

    protected array $actionDefault = [
           12,32767,32767,32767,   12,   12,32767,32767,   13,32767,
        32767,32767,    6
    ];

    protected array $goto = [
           14,    2,    0,    4
    ];

    protected array $gotoCheck = [
            2,    2,   -1,    3
    ];

    protected array $gotoBase = [
            0,    0,   -4,   -3,    0,    0,    0,    0,    0
    ];

    protected array $gotoDefault = [
        -32768,    7,    6,   20,   10,    1,   18,    8,-32768
    ];

    protected array $ruleToNonTerminal = [
            0,    1,    3,    4,    4,    5,    5,    6,    6,    7,
            7,    8,    2,    2
    ];

    protected array $ruleToLength = [
            1,    3,    5,    1,    5,    2,    0,    1,    1,    2,
            1,    1,    0,    1
    ];

    protected array $productions = [
        "\$start : root",
        "root : optional_whitespace xhp_tag optional_whitespace",
        "xhp_tag : TOKEN_ANGLE_LEFT TOKEN_TAG_NAME optional_whitespace xhp_tag_body TOKEN_ANGLE_RIGHT",
        "xhp_tag_body : TOKEN_FORWARD_SLASH",
        "xhp_tag_body : TOKEN_ANGLE_RIGHT xhp_children TOKEN_ANGLE_LEFT TOKEN_FORWARD_SLASH TOKEN_TAG_NAME",
        "xhp_children : xhp_children xhp_child",
        "xhp_children : /* empty */",
        "xhp_child : xhp_tag",
        "xhp_child : TOKEN_WHITESPACE",
        "many_whitespace : many_whitespace TOKEN_WHITESPACE",
        "many_whitespace : TOKEN_WHITESPACE",
        "required_whitespace : many_whitespace",
        "optional_whitespace : /* empty */",
        "optional_whitespace : many_whitespace"
    ];

    protected function initReduceCallbacks(): void
    {
        $this->reduceCallbacks = [
            0 => function ($stackPos) {
                $this->semValue = $this->semStack[$stackPos];
            },
            1 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(3-2)];
            },
            2 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TAG());
                                          $this->semValue->setValue([
                                              // TODO: how to determine the filename?
                                              'filename' => 'unknown',
                                              'line' => $this->lexer->getLine(),
                                          ]);
                                          $tag_name = new Node(Type::XHP_TAG_NAME());
                                          $tag_name->setValue($this->semStack[$stackPos-(5-2)]);
                                          $this->semValue->appendChild($tag_name);
                                          $this->semValue->appendChild($this->semStack[$stackPos-(5-4)]);
            },
            3 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TAG_BODY());
            },
            4 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TAG_BODY());
                                          $this->semValue->setValue([
                                              'closing_tag_name' => $this->semStack[$stackPos-(5-5)],
                                          ]);
                                          $this->semValue->appendChild($this->semStack[$stackPos-(5-2)]);
            },
            5 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(2-1)]; $this->semValue->appendChild($this->semStack[$stackPos-(2-2)]);
            },
            6 => function ($stackPos) {
                 $this->semValue = new Node(Type::CHILD_LIST());
            },
            7 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            8 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), $this->semStack[$stackPos-(1-1)]);
            },
            9 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(2-1)];
                                          $this->semValue->setValue($this->semStack[$stackPos-(2-1)]->getValue() . $this->semStack[$stackPos-(2-2)]);
            },
            10 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), $this->semStack[$stackPos-(1-1)]);
            },
            11 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            12 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), '');
            },
            13 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
        ];
    }
}

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

    protected int $tokenToSymbolMapSize = 269;
    protected int $actionTableSize = 15;
    protected int $gotoTableSize = 3;

    protected int $invalidSymbol = 14;
    protected int $errorSymbol = 1;
    protected int $defaultAction = -32766;
    protected int $unexpectedTokenRule = 32767;

    protected int $YY2TBLSTATE = 3;
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
           14,   14,   14,   14,   14,   14,    1,    7,    8,    2,
            9,    3,    4,    5,   10,   11,   12,   13,    6
    ];

    protected array $action = [
           12,   16,    0,   22,   11,   21,    0,    2,    9,    0,
           15,    0,    0,    4,   17
    ];

    protected array $actionCheck = [
            4,    5,    0,    2,    5,    2,   -1,    3,    3,   -1,
            4,   -1,   -1,    6,    6
    ];

    protected array $actionBase = [
            1,   -4,   -1,    1,    1,    4,    5,    2,    3,    7,
            6,    8,    0,    0,    0,    7
    ];

    protected array $actionDefault = [
           10,32767,32767,   10,   10,32767,32767,32767,   11,32767,
        32767,32767,    6
    ];

    protected array $goto = [
           14,    1,    3
    ];

    protected array $gotoCheck = [
            2,    2,    3
    ];

    protected array $gotoBase = [
            0,    0,   -3,   -4,    0,    0,    0,    0
    ];

    protected array $gotoDefault = [
        -32768,    7,    6,   20,   10,    5,   18,    8
    ];

    protected array $ruleToNonTerminal = [
            0,    1,    3,    4,    4,    5,    5,    6,    7,    7,
            2,    2
    ];

    protected array $ruleToLength = [
            1,    3,    5,    1,    5,    2,    0,    1,    2,    1,
            0,    1
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
        "many_whitespace : many_whitespace TOKEN_WHITESPACE",
        "many_whitespace : TOKEN_WHITESPACE",
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
                 $this->semValue = $this->semStack[$stackPos-(2-1)];
                                          $this->semValue->setValue($this->semStack[$stackPos-(2-1)]->getValue() . $this->semStack[$stackPos-(2-2)]);
            },
            9 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), $this->semStack[$stackPos-(1-1)]);
            },
            10 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), '');
            },
            11 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
        ];
    }
}

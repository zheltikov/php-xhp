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

    protected int $tokenToSymbolMapSize = 278;
    protected int $actionTableSize = 42;
    protected int $gotoTableSize = 4;

    protected int $invalidSymbol = 23;
    protected int $errorSymbol = 1;
    protected int $defaultAction = -32766;
    protected int $unexpectedTokenRule = 32767;

    protected int $YY2TBLSTATE = 5;
    protected int $numNonLeafStates = 21;

    protected array $symbolToName = [
        "EOF",
        "error",
        "TOKEN_WHITESPACE",
        "TOKEN_ANGLE_LEFT",
        "TOKEN_ANGLE_RIGHT",
        "TOKEN_FORWARD_SLASH",
        "TOKEN_CURLY_START",
        "TOKEN_CURLY_END",
        "TOKEN_TAG_NAME",
        "TOKEN_XHP_TEXT",
        "TOKEN_XHP_ENTITY",
        "TOKEN_STRING_DQ",
        "TOKEN_STRING_SQ",
        "TOKEN_RAW_FLOAT",
        "TOKEN_RAW_INTEGER",
        "TOKEN_NULL",
        "TOKEN_TRUE",
        "TOKEN_FALSE",
        "TOKEN_EOF",
        "TOKEN_NS_SEPARATOR",
        "TOKEN_ERROR",
        "TOKEN_ELLIPSIS",
        "TOKEN_EQUALS"
    ];

    protected array $tokenToSymbol = [
            0,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,   23,   23,   23,   23,
           23,   23,   23,   23,   23,   23,    1,   18,   19,    2,
           20,    3,    4,    5,    6,    7,   21,   22,    8,    9,
           10,   11,   12,   13,   14,   15,   16,   17
    ];

    protected array $action = [
           29,    4,    0,   50,    2,   52,   42,   41,   40,   43,
           44,   45,   46,   47,   48,   49,   13,   14,   15,   16,
           17,   18,   19,   20,   24,   51,   23,   10,   33,    0,
           12,    0,    0,   34,   35,   36,   37,   38,   39,    0,
            6,   25
    ];

    protected array $actionCheck = [
            2,    3,    0,    5,    6,    2,    8,    9,   10,   11,
           12,   13,   14,   15,   16,   17,   11,   12,   13,   14,
           15,   16,   17,    4,    5,    2,    4,    3,    7,   -1,
            5,   -1,   -1,    7,    7,    7,    7,    7,    7,   -1,
            8,    8
    ];

    protected array $actionBase = [
            3,   -2,    5,   19,   25,    3,    3,   24,    2,   23,
           32,   22,   33,   21,   26,   27,   28,   29,   30,   31,
            0,    0,    0,    0,    0,   32
    ];

    protected array $actionDefault = [
           33,32767,32767,32767,32767,   33,   33,32767,32767,   34,
        32767,32767,32767,32767,32767,32767,32767,32767,32767,32767,
            6
    ];

    protected array $goto = [
           22,    3,    0,    5
    ];

    protected array $gotoCheck = [
            2,    2,   -1,    3
    ];

    protected array $gotoBase = [
            0,    0,   -5,   -4,    0,    0,    0,    0,    0,    0,
            0,    0
    ];

    protected array $gotoDefault = [
        -32768,    8,    7,   28,   11,    1,   26,   30,   31,   32,
            9,-32768
    ];

    protected array $ruleToNonTerminal = [
            0,    1,    3,    4,    4,    5,    5,    6,    6,    6,
            6,    6,    9,    9,    9,    9,    9,    9,    9,    8,
            7,    7,    7,    7,    7,    7,    7,    7,    7,    7,
           10,   10,   11,    2,    2
    ];

    protected array $ruleToLength = [
            1,    3,    5,    1,    5,    2,    0,    1,    1,    1,
            1,    1,    3,    3,    3,    3,    3,    3,    3,    1,
            1,    1,    1,    1,    1,    1,    1,    1,    1,    1,
            2,    1,    1,    0,    1
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
        "xhp_child : xhp_text",
        "xhp_child : xhp_entity",
        "xhp_child : injected",
        "injected : TOKEN_CURLY_START TOKEN_STRING_DQ TOKEN_CURLY_END",
        "injected : TOKEN_CURLY_START TOKEN_STRING_SQ TOKEN_CURLY_END",
        "injected : TOKEN_CURLY_START TOKEN_RAW_FLOAT TOKEN_CURLY_END",
        "injected : TOKEN_CURLY_START TOKEN_RAW_INTEGER TOKEN_CURLY_END",
        "injected : TOKEN_CURLY_START TOKEN_NULL TOKEN_CURLY_END",
        "injected : TOKEN_CURLY_START TOKEN_TRUE TOKEN_CURLY_END",
        "injected : TOKEN_CURLY_START TOKEN_FALSE TOKEN_CURLY_END",
        "xhp_entity : TOKEN_XHP_ENTITY",
        "xhp_text : TOKEN_XHP_TEXT",
        "xhp_text : TOKEN_TAG_NAME",
        "xhp_text : TOKEN_STRING_DQ",
        "xhp_text : TOKEN_STRING_SQ",
        "xhp_text : TOKEN_RAW_FLOAT",
        "xhp_text : TOKEN_RAW_INTEGER",
        "xhp_text : TOKEN_NULL",
        "xhp_text : TOKEN_TRUE",
        "xhp_text : TOKEN_FALSE",
        "xhp_text : TOKEN_FORWARD_SLASH",
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
                                          $closing_tag_name = $this->semStack[$stackPos-(5-4)]->getValue();
                                          if (!array_key_exists('closing_tag_name', $closing_tag_name)) {
                                              throw new \RuntimeException('Expected `closing_tag_name` not found!');
                                          }
                                          $closing_tag_name = $closing_tag_name['closing_tag_name'];
                                          if ($closing_tag_name !== $this->semStack[$stackPos-(5-2)]) {
                                              throw new \RuntimeException(
                                                  sprintf(
                                                      'Closing tag name mismatch: <%s>%s</%s>',
                                                      $this->semStack[$stackPos-(5-2)],
                                                      $this->semStack[$stackPos-(5-4)]->hasChildren()
                                                      && $this->semStack[$stackPos-(5-4)]->getChildAt(0)->hasChildren()
                                                          ? '...' : '',
                                                      $closing_tag_name
                                                  )
                                              );
                                          }
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
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            10 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            11 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            12 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), substr($this->semStack[$stackPos-(3-2)], 1, -1));
            },
            13 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), substr($this->semStack[$stackPos-(3-2)], 1, -1));
            },
            14 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), floatval($this->semStack[$stackPos-(3-2)]));
            },
            15 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), intval($this->semStack[$stackPos-(3-2)]));
            },
            16 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), null);
            },
            17 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), true);
            },
            18 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), false);
            },
            19 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_ENTITY(), $this->semStack[$stackPos-(1-1)]);
            },
            20 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            21 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            22 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            23 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            24 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            25 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            26 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            27 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            28 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            29 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            30 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(2-1)];
                                          $this->semValue->setValue($this->semStack[$stackPos-(2-1)]->getValue() . $this->semStack[$stackPos-(2-2)]);
            },
            31 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), $this->semStack[$stackPos-(1-1)]);
            },
            32 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            33 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), '');
            },
            34 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
        ];
    }
}

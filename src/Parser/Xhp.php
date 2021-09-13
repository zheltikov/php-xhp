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
    protected int $actionTableSize = 51;
    protected int $gotoTableSize = 5;

    protected int $invalidSymbol = 23;
    protected int $errorSymbol = 1;
    protected int $defaultAction = -32766;
    protected int $unexpectedTokenRule = 32767;

    protected int $YY2TBLSTATE = 6;
    protected int $numNonLeafStates = 25;

    protected array $symbolToName = [
        "EOF",
        "error",
        "TOKEN_WHITESPACE",
        "TOKEN_ANGLE_LEFT",
        "TOKEN_ANGLE_RIGHT",
        "TOKEN_FORWARD_SLASH",
        "TOKEN_CURLY_START",
        "TOKEN_CURLY_END",
        "TOKEN_EQUALS",
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
        "TOKEN_ELLIPSIS"
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
           23,   23,   23,   23,   23,   23,    1,   19,   20,    2,
           21,    3,    4,    5,    6,    7,   22,    8,    9,   10,
           11,   12,   13,   14,   15,   16,   17,   18
    ];

    protected array $action = [
           39,    5,   62,   60,    2,   64,   61,   52,   51,   50,
           53,   54,   55,   56,   57,   58,   59,   16,   17,   18,
           19,   20,   21,   22,   24,   28,    0,   63,   27,   43,
           11,   14,    0,   15,    0,    0,   44,   45,   46,   47,
           48,   49,    0,    0,   23,   29,   13,    0,    0,    0,
           34
    ];

    protected array $actionCheck = [
            2,    3,    4,    5,    6,    2,    8,    9,   10,   11,
           12,   13,   14,   15,   16,   17,   18,   12,   13,   14,
           15,   16,   17,   18,    4,    5,    0,    2,    4,    7,
            3,    8,   -1,    5,   -1,   -1,    7,    7,    7,    7,
            7,    7,   -1,   -1,    9,    9,    9,   -1,   -1,   -1,
           12
    ];

    protected array $actionBase = [
            3,   -2,    5,   37,   20,   28,    3,    3,   27,   26,
           25,   35,   24,   23,   38,   36,   22,   29,   30,   31,
           32,   33,   34,    0,    0,    0,    0,    0,   25,    0,
           35
    ];

    protected array $actionDefault = [
           40,32767,32767,   41,32767,32767,   40,   40,32767,32767,
           41,32767,32767,   10,32767,32767,32767,32767,32767,32767,
        32767,32767,32767,    8,   12
    ];

    protected array $goto = [
           26,    4,    3,    0,    6
    ];

    protected array $gotoCheck = [
            2,    2,    8,   -1,    3
    ];

    protected array $gotoBase = [
            0,    0,   -6,   -4,    0,    0,    0,    0,   -5,    0,
            0,    0,    0,    0
    ];

    protected array $gotoDefault = [
        -32768,    9,    8,   38,   12,    7,    1,-32768,   10,   32,
           36,   40,   41,   42
    ];

    protected array $ruleToNonTerminal = [
            0,    1,    3,    4,    4,    7,    7,    5,    5,    9,
            9,    6,    6,   10,   10,   10,   10,   10,   13,   13,
           13,   13,   13,   13,   13,   12,   11,   11,   11,   11,
           11,   11,   11,   11,   11,   11,   11,   11,    8,    8,
            2,    2
    ];

    protected array $ruleToLength = [
            1,    3,    4,    3,    7,    0,    2,    3,    0,    3,
            1,    2,    0,    1,    1,    1,    1,    1,    3,    3,
            3,    3,    3,    3,    3,    1,    1,    1,    1,    1,
            1,    1,    1,    1,    1,    1,    1,    1,    2,    1,
            0,    1
    ];

    protected array $productions = [
        "\$start : root",
        "root : optional_whitespace xhp_tag optional_whitespace",
        "xhp_tag : TOKEN_ANGLE_LEFT TOKEN_TAG_NAME xhp_tag_body TOKEN_ANGLE_RIGHT",
        "xhp_tag_body : xhp_attributes optional_whitespace TOKEN_FORWARD_SLASH",
        "xhp_tag_body : xhp_attributes optional_whitespace TOKEN_ANGLE_RIGHT xhp_children TOKEN_ANGLE_LEFT TOKEN_FORWARD_SLASH TOKEN_TAG_NAME",
        "xhp_attrs : /* empty */",
        "xhp_attrs : many_whitespace xhp_attributes",
        "xhp_attributes : xhp_attributes many_whitespace xhp_attribute",
        "xhp_attributes : /* empty */",
        "xhp_attribute : TOKEN_TAG_NAME TOKEN_EQUALS TOKEN_STRING_DQ",
        "xhp_attribute : TOKEN_TAG_NAME",
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
        "xhp_text : TOKEN_EQUALS",
        "xhp_text : TOKEN_ANGLE_RIGHT",
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
                                          $tag_name->setValue($this->semStack[$stackPos-(4-2)]);
                                          $this->semValue->appendChild($tag_name);
                                          $self_closing = (bool) $this->semStack[$stackPos-(4-3)]->getFromValue('self_closing');
                                          if (!$self_closing) {
                                              $closing_tag_name = $this->semStack[$stackPos-(4-3)]->getValue();
                                              if (!array_key_exists('closing_tag_name', $closing_tag_name)) {
                                                  throw new \RuntimeException('Expected `closing_tag_name` not found!');
                                              }
                                              $closing_tag_name = $closing_tag_name['closing_tag_name'];
                                              if ($closing_tag_name !== $this->semStack[$stackPos-(4-2)]) {
                                                  throw new \RuntimeException(
                                                      sprintf(
                                                          'Closing tag name mismatch: <%s> and </%s>',
                                                          $this->semStack[$stackPos-(4-2)],
                                                          $closing_tag_name
                                                      )
                                                  );
                                              }
                                          }
                                          $this->semValue->appendChild($this->semStack[$stackPos-(4-3)]);
            },
            3 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TAG_BODY());
                                          $this->semValue->setValue([
                                              'self_closing' => true,
                                              'attributes' => $this->semStack[$stackPos-(3-1)],
                                          ]);
            },
            4 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TAG_BODY());
                                          $this->semValue->setValue([
                                              'attributes' => $this->semStack[$stackPos-(7-1)],
                                              'closing_tag_name' => $this->semStack[$stackPos-(7-7)],
                                          ]);
                                          $this->semValue->appendChild($this->semStack[$stackPos-(7-4)]);
            },
            5 => function ($stackPos) {
                 $this->semValue = new Node(Type::ATTRIBUTES());
            },
            6 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(2-2)];
            },
            7 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(3-1)]; $this->semValue->appendChild($this->semStack[$stackPos-(3-3)]);
            },
            8 => function ($stackPos) {
                 $this->semValue = new Node(Type::ATTRIBUTES());
            },
            9 => function ($stackPos) {
                 $this->semValue = new Node(Type::ATTRIBUTE());
                                          $this->semValue->setValue([
                                              'name' => $this->semStack[$stackPos-(3-1)],
                                              'value' => substr($this->semStack[$stackPos-(3-3)], 1, -1),
                                          ]);
            },
            10 => function ($stackPos) {
                 $this->semValue = new Node(Type::ATTRIBUTE());
                                          $this->semValue->setValue([
                                              'name' => $this->semStack[$stackPos-(1-1)],
                                              'value' => null,
                                          ]);
            },
            11 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(2-1)]; $this->semValue->appendChild($this->semStack[$stackPos-(2-2)]);
            },
            12 => function ($stackPos) {
                 $this->semValue = new Node(Type::CHILD_LIST());
            },
            13 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            14 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), $this->semStack[$stackPos-(1-1)]);
            },
            15 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            16 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            17 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            18 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), substr($this->semStack[$stackPos-(3-2)], 1, -1));
            },
            19 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), substr($this->semStack[$stackPos-(3-2)], 1, -1));
            },
            20 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), floatval($this->semStack[$stackPos-(3-2)]));
            },
            21 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), intval($this->semStack[$stackPos-(3-2)]));
            },
            22 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), null);
            },
            23 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), true);
            },
            24 => function ($stackPos) {
                 $this->semValue = new Node(Type::INJECTED(), false);
            },
            25 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_ENTITY(), $this->semStack[$stackPos-(1-1)]);
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
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            31 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            32 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            33 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            34 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            35 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            36 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            37 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            38 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(2-1)];
                                          $this->semValue->setValue($this->semStack[$stackPos-(2-1)]->getValue() . $this->semStack[$stackPos-(2-2)]);
            },
            39 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), $this->semStack[$stackPos-(1-1)]);
            },
            40 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), '');
            },
            41 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
        ];
    }
}

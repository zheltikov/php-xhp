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

    protected int $tokenToSymbolMapSize = 271;
    protected int $actionTableSize = 18;
    protected int $gotoTableSize = 4;

    protected int $invalidSymbol = 16;
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
        "TOKEN_XHP_TEXT",
        "TOKEN_XHP_ENTITY",
        "TOKEN_EOF",
        "TOKEN_NS_SEPARATOR",
        "TOKEN_ERROR",
        "TOKEN_CURLY_START",
        "TOKEN_CURLY_END",
        "TOKEN_ELLIPSIS",
        "TOKEN_EQUALS"
    ];

    protected array $tokenToSymbol = [
            0,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,   16,   16,   16,   16,
           16,   16,   16,   16,   16,   16,    1,    9,   10,    2,
           11,    3,    4,    5,   12,   13,   14,   15,    6,    7,
            8
    ];

    protected array $action = [
           21,    3,    0,   28,   26,   25,   24,   12,   16,   27,
           15,    9,    0,    0,   11,    0,    5,   17
    ];

    protected array $actionCheck = [
            2,    3,    0,    2,    6,    7,    8,    4,    5,    2,
            4,    3,   -1,   -1,    5,   -1,    6,    6
    ];

    protected array $actionBase = [
            1,   -2,    3,    9,    1,    1,    8,    2,    7,   10,
            6,   11,    0,    0,    0,    0,   10
    ];

    protected array $actionDefault = [
           17,32767,32767,32767,   17,   17,32767,32767,   18,32767,
        32767,32767,    6
    ];

    protected array $goto = [
           14,    2,    0,    4
    ];

    protected array $gotoCheck = [
            2,    2,   -1,    3
    ];

    protected array $gotoBase = [
            0,    0,   -4,   -3,    0,    0,    0,    0,    0,    0,
            0
    ];

    protected array $gotoDefault = [
        -32768,    7,    6,   20,   10,    1,   18,   22,   23,    8,
        -32768
    ];

    protected array $ruleToNonTerminal = [
            0,    1,    3,    4,    4,    5,    5,    6,    6,    6,
            6,    8,    7,    7,    9,    9,   10,    2,    2
    ];

    protected array $ruleToLength = [
            1,    3,    5,    1,    5,    2,    0,    1,    1,    1,
            1,    1,    1,    1,    2,    1,    1,    0,    1
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
        "xhp_entity : TOKEN_XHP_ENTITY",
        "xhp_text : TOKEN_XHP_TEXT",
        "xhp_text : TOKEN_TAG_NAME",
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
                 $this->semValue = new Node(Type::XHP_ENTITY(), $this->semStack[$stackPos-(1-1)]);
            },
            12 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            13 => function ($stackPos) {
                 $this->semValue = new Node(Type::XHP_TEXT(), $this->semStack[$stackPos-(1-1)]);
            },
            14 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(2-1)];
                                          $this->semValue->setValue($this->semStack[$stackPos-(2-1)]->getValue() . $this->semStack[$stackPos-(2-2)]);
            },
            15 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), $this->semStack[$stackPos-(1-1)]);
            },
            16 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
            17 => function ($stackPos) {
                 $this->semValue = new Node(Type::WHITESPACE(), '');
            },
            18 => function ($stackPos) {
                 $this->semValue = $this->semStack[$stackPos-(1-1)];
            },
        ];
    }
}

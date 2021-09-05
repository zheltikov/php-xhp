<?php

namespace Zheltikov\Xhp\Parser;

use InvalidArgumentException;
use RuntimeException;
use Tmilos\Lexer\Config\LexerArrayConfig;
use Tmilos\Lexer\Config\TokenDefn;
use Tmilos\Lexer\Token;

class Lexer
{
    /**
     * @var \Tmilos\Lexer\Token[]
     */
    protected array $tokens;

    protected int $pos;
    protected int $line;
    protected int $filePos;

    protected array $dropTokens;

    private bool $attributeStartLineUsed;
    private bool $attributeEndLineUsed;
    private bool $attributeStartTokenPosUsed;
    private bool $attributeEndTokenPosUsed;
    private bool $attributeStartFilePosUsed;
    private bool $attributeEndFilePosUsed;

    /**
     * Creates a Lexer.
     *
     * @param array $options Options array. Currently only the 'usedAttributes' option is supported,
     *                       which is an array of attributes to add to the AST nodes. Possible
     *                       attributes are: 'comments', 'startLine', 'endLine', 'startTokenPos',
     *                       'endTokenPos', 'startFilePos', 'endFilePos'. The option defaults to the
     *                       first three. For more info see getNextToken() docs.
     */
    public function __construct(array $options = [])
    {
        // map of tokens to drop while lexing (the map is only used for isset lookup,
        // that's why the value is simply set to 1; the value is never actually used.)
        $this->dropTokens = array_fill_keys(
            [
                // Tokens::TOKEN_WHITESPACE()->getKey(),
            ],
            1
        );

        $defaultAttributes = [];
        $usedAttributes = array_fill_keys($options['usedAttributes'] ?? $defaultAttributes, true);

        // Create individual boolean properties to make these checks faster.
        $this->attributeStartLineUsed = isset($usedAttributes['startLine']);
        $this->attributeEndLineUsed = isset($usedAttributes['endLine']);
        $this->attributeStartTokenPosUsed = isset($usedAttributes['startTokenPos']);
        $this->attributeEndTokenPosUsed = isset($usedAttributes['endTokenPos']);
        $this->attributeStartFilePosUsed = isset($usedAttributes['startFilePos']);
        $this->attributeEndFilePosUsed = isset($usedAttributes['endFilePos']);
    }

    /**
     * @return array
     */
    public static function getTokenDefinitions(): array
    {
        $label = "[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*";
        $xhp_label = "$label([:-]$label)*";

        return [
            '[ \n\r\t]+' => Tokens::TOKEN_WHITESPACE(),
            '<' => Tokens::TOKEN_ANGLE_LEFT(),
            '>' => Tokens::TOKEN_ANGLE_RIGHT(),
            '/' => Tokens::TOKEN_FORWARD_SLASH(),
            '{' => Tokens::TOKEN_CURLY_START(),
            '}' => Tokens::TOKEN_CURLY_END(),
            '\.\.\.' => Tokens::TOKEN_ELLIPSIS(),
            '=' => Tokens::TOKEN_EQUALS(),
            $xhp_label => Tokens::TOKEN_TAG_NAME(),
        ];
    }

    /**
     * Initializes the lexer for lexing the provided source code.
     *
     * This function does not throw if lexing errors occur. Instead, errors may be retrieved using
     * the getErrors() method.
     *
     * @param string $code The source code to lex
     */
    public function startLexing(
        string $code
    ) {
        $this->pos = -1;
        $this->line = 1;
        $this->filePos = 0;

        $this->tokens = $this->token_get_all($code);
        //var_dump($this->tokens);
        $this->postprocessTokens();
    }

    protected function postprocessTokens(): void
    {
        // ...
    }

    /**
     * @param string $code
     * @return array
     */
    protected function token_get_all(
        string $code
    ): array {
        $defs = [];
        /** @var \Zheltikov\Xhp\Parser\Tokens $token */
        foreach (static::getTokenDefinitions() as $regex => $token) {
            if ($token instanceof TokenDefn) {
                $defs[] = $token;
            } elseif (is_string($regex) && $token instanceof Tokens) {
                $defs['(?:' . $regex . ')'] = $token->getKey();
            } else {
                throw new InvalidArgumentException(
                    sprintf(
                        'Invalid token definition: %s => %s',
                        var_export($regex, true),
                        var_export($token, true),
                    )
                );
            }
        }
        $config = new LexerArrayConfig($defs);

        $tokens = \Tmilos\Lexer\Lexer::scan($config, $code);

        $valid_tokens = Tokens::values();

        return array_map(function (Token $token) use ($valid_tokens): array {
            return [
                'code' => $valid_tokens[$token->getName()]->getValue(),
                'name' => $token->getName(),
                'offset' => $token->getOffset(),
                'position' => $token->getPosition(),
                'value' => $token->getValue(),
            ];
        }, $tokens);
    }

    /**
     * Fetches the next token.
     *
     * The available attributes are determined by the 'usedAttributes' option, which can
     * be specified in the constructor. The following attributes are supported:
     *
     *  * 'comments'      => Array of PhpParser\Comment or PhpParser\Comment\Doc instances,
     *                       representing all comments that occurred between the previous
     *                       non-discarded token and the current one.
     *  * 'startLine'     => Line in which the node starts.
     *  * 'endLine'       => Line in which the node ends.
     *  * 'startTokenPos' => Offset into the token array of the first token in the node.
     *  * 'endTokenPos'   => Offset into the token array of the last token in the node.
     *  * 'startFilePos'  => Offset into the code string of the first character that is part of the node.
     *  * 'endFilePos'    => Offset into the code string of the last character that is part of the node.
     *
     * @param mixed $value Variable to store token content in
     * @param mixed $startAttributes Variable to store start attributes in
     * @param mixed $endAttributes Variable to store end attributes in
     *
     * @return int Token id
     */
    public function getNextToken(
        &$value = null,
        &$startAttributes = null,
        &$endAttributes = null
    ): int {
        $startAttributes = [];
        $endAttributes = [];

        while (1) {
            if (isset($this->tokens[++$this->pos])) {
                $token = $this->tokens[$this->pos];
            } else {
                // EOF token with ID 0
                $token = "\0";
            }

            if ($this->attributeStartLineUsed) {
                $startAttributes['startLine'] = $this->line;
            }
            if ($this->attributeStartTokenPosUsed) {
                $startAttributes['startTokenPos'] = $this->pos;
            }
            if ($this->attributeStartFilePosUsed) {
                $startAttributes['startFilePos'] = $this->filePos;
            }

            if (is_string($token)) {
                $value = $token;
                if (isset($token[1])) {
                    // bug in token_get_all
                    $this->filePos += 2;
                    $id = ord('"');
                } else {
                    $this->filePos += 1;
                    $id = ord($token);
                }
            } elseif (!isset($this->dropTokens[$token['name']])) {
                $value = $token['value'];
                $id = $token['code'];

                $this->line += substr_count($value, "\n");
                $this->filePos += strlen($value);
            } else {
                $this->line += substr_count($token['value'], "\n");
                $this->filePos += strlen($token['value']);

                continue;
            }

            if ($this->attributeEndLineUsed) {
                $endAttributes['endLine'] = $this->line;
            }
            if ($this->attributeEndTokenPosUsed) {
                $endAttributes['endTokenPos'] = $this->pos;
            }
            if ($this->attributeEndFilePosUsed) {
                $endAttributes['endFilePos'] = $this->filePos - 1;
            }

            return $id;
        }

        // This should never occur! :)
        throw new RuntimeException('Reached end of lexer loop');
    }

    /**
     * Returns the token array for current code.
     *
     * The token array is in the same format as provided by the
     * token_get_all() function and does not discard tokens (i.e.
     * whitespace and comments are included). The token position
     * attributes are against this token array.
     *
     * @return \Tmilos\Lexer\Token[] Array of tokens in token_get_all() format
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }
}

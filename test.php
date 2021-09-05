<?php

use Zheltikov\Xhp\Parser\Lexer;
use Zheltikov\Xhp\Parser\Node;
use Zheltikov\Xhp\Parser\Xhp;

require_once(__DIR__ . '/vendor/autoload.php');

/**
 * @param string $code
 * @return \Zheltikov\Xhp\Parser\Node|null
 */
function xhp_parse(string $code): ?Node
{
    $lexer = new Lexer();
    $parser = new Xhp($lexer);

    try {
        $ast = $parser->parse($code);
    } catch (Throwable $error) {
        throw new RuntimeException(
            sprintf(
                'Parse Error%s: %s',
                $error->getCode() ? ' ' . $error->getCode() : '',
                $error->getMessage()
            )
        );
    }

    return $ast;
}

$input_xhp = (string) ($_REQUEST['input_xhp'] ?? "<test-tag></test-tag>");

echo '<body>';
echo '<form method="get" action="test.php">';
echo sprintf(
    'XHP:<br /><textarea name="input_xhp" style="width: 100%%; height: 30vh;">%s</textarea><br />',
    htmlentities($input_xhp)
);
echo '<button>Ok</button>';
echo '</form>';

$parse_error = false;
try {
    $result = xhp_parse($input_xhp);
} catch (Throwable $e) {
    $parse_error = true;
    $result = $e;
}

echo sprintf(
    '<pre style="overflow: auto; %s">',
    $parse_error
        ? 'background: tomato; color: lightyellow;'
        : 'background: grey; color: #eee;'
);
print_r($result);
echo '</pre>';
echo '</body>';

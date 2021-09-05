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

echo "<style>
body {
    background-color: #111;
    color: #eee;
}
textarea {
    background-color: inherit;
    color: inherit;
    resize: vertical;
    min-height: 100px;
    max-height: 90vh;
    width: 100%;
    height: 30vh;
}
button {
    background-color: green;
}
pre {
    background: #333;
    color: #eee;
    overflow: auto;
}
pre.error {
    background: darkred;
    color: lightyellow;
}
</style>";

echo sprintf(
    'input: <pre>%s</pre><hr />',
    var_export(htmlspecialchars($input_xhp), true)
);

echo '<body>';
echo '<form method="post" action="test.php">';
echo sprintf(
    'XHP:<br /><textarea name="input_xhp">%s</textarea><br />',
    "\n" . htmlentities($input_xhp)
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

echo $parse_error
    ? '<pre class="error">'
    : '<pre>';
print_r($result);
echo '</pre>';
echo '</body>';

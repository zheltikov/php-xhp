<?php

ini_set('memory_limit', '2048M');

use Zheltikov\Xhp\Core\ChildValidation;
use Zheltikov\Xhp\Parser\Converter;
use Zheltikov\Xhp\Parser\Lexer;
use Zheltikov\Xhp\Parser\Node;
use Zheltikov\Xhp\Parser\Optimizer;
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

// TODO: remove later, after tests
ChildValidation::disable();

$input_xhp = (string) ($_REQUEST['input_xhp'] ?? "<test-tag></test-tag>");

echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
echo "<style>
* {
    outline: none;
}
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
    background: #222;
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

$form_id = base_convert(rand(), 10, 36);
$textarea_id = base_convert(rand(), 10, 36);
$pre_id = base_convert(rand(), 10, 36);

echo sprintf('<form method="get" action="test.php" id="%s">', $form_id);
echo sprintf(
    'XHP:<br /><textarea name="input_xhp" autofocus id="%s">%s</textarea><br />',
    $textarea_id,
    "\n" . htmlentities($input_xhp)
);
echo '<button>Ok</button>';
echo '</form>';

echo sprintf(
    "<script>
function render_pre(data, pre_id) {
    const pre = $('pre#' + pre_id);
    pre.text(JSON.stringify(data, null, 2));
}

$(() => {
    const form = $('form#%s');
    $(document).keydown(event => {
        if (event.ctrlKey && event.keyCode === 13) {
            form.trigger('submit');
        }
    });
    
    const textarea = $('textarea#%s');
    textarea.keydown(function (event) {
        if (event.keyCode === 9) { // tab was pressed
            // get caret position/selection
            const start = this.selectionStart;
            const end = this.selectionEnd;
            
            const \$this = $(this);
            const value = \$this.val();
            
            // set textarea value to: text before caret + tab + text after caret
            \$this.val(value.substring(0, start)
                + \"\t\"
                + value.substring(end));
            
            // put caret at right position again (add one for the tab)
            this.selectionStart = this.selectionEnd = start + 1;
            
            // prevent the focus lose
            event.preventDefault();
        }
    });
});
</script>",
    $form_id,
    $textarea_id,
);

$parse_error = false;
try {
    $result = xhp_parse($input_xhp);
    $optimizer = new Optimizer();
    $optimizer->setRootNode($result);
    $optimizer->execute();
    $result = $optimizer->getRootNode();
} catch (Throwable $e) {
    $parse_error = true;
    $result = $e;
}

$js = '';
if ($parse_error) {
    echo sprintf('<pre id="%s" class="error">', $pre_id);
    echo htmlspecialchars(print_r($result, true));
    echo '</pre>';
} else {
    echo sprintf('<pre id="%s"></pre>', $pre_id);
    $js = sprintf('render_pre(%s, %s);', json_encode($result), json_encode($pre_id));
}

echo '<hr />';

if (!$parse_error) {
    try {
        $pre_id_2 = base_convert(rand(), 10, 36);
        echo sprintf('<pre id="%s"></pre>', $pre_id_2);

        $converter = new Converter();
        $converter->setRootNode($result);
        $converter->execute();
        /** @var \Zheltikov\Xhp\Core\Node $converted */
        $converted = $converter->getResult();

        $js .= sprintf(
            'render_pre(%s, %s);',
            json_encode($converted),
            json_encode($pre_id_2)
        );

        echo 'XHP-&gt;toString(): <br />';
        echo '<textarea>' . htmlspecialchars($converted->toString()) . '</textarea>';
    } catch (Throwable $e) {
        echo '<pre class="error">';
        echo htmlspecialchars(print_r($e, true));
        echo '</pre>';
    }
}

echo '<script>' . $js . '</script>';

echo '</body>';


#!/usr/bin/env php
<?php

require_once(__DIR__ . '/../vendor/autoload.php');

/**
 * See the following page for source:
 * https://html.spec.whatwg.org/multipage/named-characters.html
 *
 * JSON source:
 * https://html.spec.whatwg.org/entities.json
 */

echo 'Updating entity list...';

$source = 'https://html.spec.whatwg.org/entities.json';
$target = __DIR__ . '/../data/entities.json';
file_put_contents($target, file_get_contents($source));

echo "Done\n";

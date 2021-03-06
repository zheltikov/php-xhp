#!/usr/bin/env php
<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$namespace = 'Zheltikov\\Xhp\\Html\\Tags\\';
$tags_path = __DIR__ . '/../src/Html/Tags/';
$files = scandir($tags_path);

$tag_map = [];
foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }

    $class_name = basename($file, '.php');

    $tag_name = [];
    $tag_name_parts = preg_split("/(?=[A-Z])/", ltrim($class_name, '_'));
    foreach ($tag_name_parts as $i => $tag_name_part) {
        if ($i) {
            $tag_name[] = strtolower($tag_name_part);
        }
    }
    $tag_name = implode('-', $tag_name);

    $tag_map[$tag_name] = $namespace . $class_name;
}

ksort($tag_map);

echo <<<PHP
<?php

/**
 * @generated
 * 
 * To regenerate this map file, run:
 * ```shell
 * $ composer run regenerate-tag-map
 * ```
 */

namespace Zheltikov\Xhp\Html;

class TagMap
{
    /**
     * @return array
     */
    public static function getTagMap(): array
    {
        return [

PHP;

foreach ($tag_map as $tag_name => $class_name) {
    echo str_repeat('    ', 3);
    var_export($tag_name);
    echo ' => ';
    var_export($class_name);
    echo ",\n";
}

echo <<<PHP
        ];
    }
}

PHP;

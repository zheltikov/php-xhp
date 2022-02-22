#!/usr/bin/env php
<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$entities_path = __DIR__ . '/../data/entities.json';
$entities = json_decode(
    file_get_contents($entities_path),
    true
);

echo <<<PHP
<?php

/**
 * @generated
 * 
 * To regenerate this map file, run:
 * ```shell
 * $ composer run generate-entity-table
 * ```
 */

namespace Zheltikov\Xhp\Html;

class NamedEntityList
{
    /**
     * @return array
     */
    public static function getList(): array
    {
        return [

PHP;

ksort($entities);
foreach ($entities as $entity => $info) {
    echo str_repeat('    ', 3);
    var_export($entity);
    echo ' => [\'codepoints\' => [';
    echo implode(', ', $info['codepoints']);
    echo '], \'characters\' => ';
    echo json_encode($info['characters']);
    echo "],\n";
}

echo <<<PHP
        ];
    }
}

PHP;

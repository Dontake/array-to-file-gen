#!/usr/bin/php
<?php
/**
 * Example of using the library
 */

require __DIR__ . '/../vendor/autoload.php';

use Domtake\ArrayToFileGenerator\Generator;

$workersArray = [
    "name" => "Иван",
    "position" => "Директор",
    "employees" => [
        [
            "name" => "Андрей",
            "position" => "Зам. Директора",
            "employees" => [
                [
                    "name" => "Максим",
                    "position" => "Дворник",
                ],
                [
                    "name" => "Алексей",
                    "position" => "Охранник",
                ]
            ],
        ],
    ],
];

if ($argc != 3 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
    echo 'Доступные опции --type, --output';
}

$type = substr(strrchr($argv[1], '='), 1);
$output = substr(strrchr($argv[2], '='), 1);

$fileName = "workers.$type";
$path = __DIR__.'\\'.$output.'\\'.$fileName;

Generator::fileGenerator($workersArray, $path, $type);

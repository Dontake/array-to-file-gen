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


$type = 'xml';
$path = __DIR__. '\\workers.'.$type;

Generator::fileGenerator($workersArray, $path, $type);

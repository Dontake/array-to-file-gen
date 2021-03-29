<?php

namespace Domtake\ArrayToFileGenerator;

use Domtake\ArrayToFileGenerator\Csv\CsvGenerator;
use Domtake\ArrayToFileGenerator\Json\JsonGenerator;
use Domtake\ArrayToFileGenerator\Xml\XmlGenerator;
use Exception;

/**
 * Class Generator
 * @package Domtake\ArrayToFileGenerator
 */
class Generator
{
    const TYPE_XML = 'xml';
    const TYPE_JSON = 'json';
    const TYPE_CSV = 'csv';

    /**
     * Create file
     *
     * @param Creator $creator
     * @return File
     */
    static function createFile(Creator $creator): File
    {
        return $creator->createFileFromPath();
    }

    /**
     * Generate a file in a given directory and specified type
     *
     * @param array $workersArray
     * @param string $path path to directory and name of file
     * @param string $type type of creating file
     */
    static function fileGenerator(array $workersArray, string $path, string $type)
    {
        self::makeDir($path);

        switch ($type) {
            case self::TYPE_XML:
                self::createFile(new XmlGenerator($workersArray, $path));
                break;

            case self::TYPE_JSON:
                self::createFile(new JsonGenerator($workersArray, $path));
                break;

            case self::TYPE_CSV:
                self::createFile(new CsvGenerator($workersArray, $path));
                break;

            default:
                echo 'invalid type specified!';
        }
    }

    /**
     * Create a directory in a given path if it does not exist
     *
     * @param string $path path to directory
     */
    static function makeDir(string $path)
    {
        $path_info = pathinfo($path);
        $dir = $path_info['dirname'];

        try {
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
        } catch (Exception $e) {
            // if directory can't create
            echo "There was a problem with the directory: " . $e->getMessage();
        }
    }
}
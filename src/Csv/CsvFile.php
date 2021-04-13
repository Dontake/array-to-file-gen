<?php

namespace Domtake\ArrayToFileGenerator\Csv;

use Domtake\ArrayToFileGenerator\File;
use Exception;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

/**
 * Class CsvFile
 * @package Domtake\ArrayToFileGenerator
 */
class CsvFile implements File
{
    const DELIMITER = ',';
    const ENCLOSURE = '"';
    const ESCAPE_CHAR = "\\";

    private $workersArray, $path;


    public function __construct(array $workersArray, string $path)
    {
        $this->workersArray = $workersArray;
        $this->path = $path;
    }


    /**
     * Create CSV file in a given directory
     * Write array of pages to this file
     *
     */
    public function create()
    {
        try {
            $workersArray = $this->workersArray;
            $csv_file = fopen($this->path, 'w');
            $this->writeRows($workersArray, $csv_file);

            fputcsv($csv_file, $workersArray, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);

            fclose($csv_file);
            echo "workers.csv created successfully!";
        } catch (Exception $e) {
            // if file can't create
            echo $e->getMessage();
        }
    }

    /**
     * Write rows to the beginning of the file
     *
     * @param array $workersArray
     * @param $csv_file
     */
    protected function writeRows(array $workersArray, $csv_file)
    {
        $csv_rows = null;

        $csv_rows = array_keys($workersArray);

        fputcsv($csv_file, $csv_rows, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);
    }
}
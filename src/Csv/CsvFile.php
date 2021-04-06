<?php

namespace Domtake\ArrayToFileGenerator\Csv;

use Domtake\ArrayToFileGenerator\File;
use Exception;

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
            $csv_file = fopen($this->path, 'w');
            $this->writeRows($this->workersArray, $csv_file);

            foreach ($this->workersArray as $item) {
                fputcsv($csv_file, $item, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);

                foreach ($item['employees'] as $employee) {
                    fputcsv($csv_file, $employee, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);

                    foreach ($employee['employees'] as $element) {
                        fputcsv($csv_file, $element, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);
                    }
                }
            }

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

        foreach ($workersArray as $row) {
            $csv_rows = array_keys($row[0]);
        }

        fputcsv($csv_file, $csv_rows, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);
    }
}
<?php

namespace Domtake\ArrayToFileGenerator\Csv;

use Domtake\ArrayToFileGenerator\File;

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
        $csv_file = fopen($this->path, 'w');
        $this->writeRows($this->workersArray, $csv_file);

        foreach ($this->workersArray as $item) {
            fputcsv($csv_file, $item, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);

            foreach ($item as $element) {
                fputcsv($csv_file, $element, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);

                foreach ($element as $row) {
                    fputcsv($csv_file, $row, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);
                }
            }
        }

        fclose($csv_file);
        echo "workers.csv created successfully!";
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

        foreach ($workersArray as $row1) {
            $csv_rows = array_keys($row1);

            foreach ($row1 as $row2) {
                $csv_rows = array_keys($row2);

                foreach ($row2 as $row3) {
                    $csv_rows = array_keys($row3);
                }
            }
        }

        fputcsv($csv_file, $csv_rows, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);
    }
}
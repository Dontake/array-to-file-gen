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
            $workersArray = $this->workersArray;
            $csvFile = fopen($this->path, 'w');

            $csvData = $this->createCsvData($workersArray);
            $record = false;

            if (!empty($csvData) && is_array($csvData)) {

                foreach ($csvData as $csvDatum) {
                    fputcsv($csvFile, $csvDatum, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);
                }

                $record = true;
            }

            fclose($csvFile);

            if ($record) {
                echo "workers.csv created successfully!";
            }
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

        $this->putCSV($csv_file, $csv_rows);
    }

    /**
     * Recursive write array to .csv file
     *
     * @param $csv_file
     * @param $value
     * @param array $offset
     * @return void
     */
    protected function putCSV($csv_file, $value, $offset = [])
    {
        if (!is_array($value)) {
            return;
        }

        $filteredValue = array_filter($value, function ($key) {
            return !is_array($key);
        });

        if (!empty($filteredValue)) {
            $result = array_merge($offset, $filteredValue);

            fputcsv($csv_file, $result, self::DELIMITER, self::ENCLOSURE, self::ESCAPE_CHAR);

            array_push($offset, '');
        }

        foreach ($value as $item) {
            $this->putCSV($csv_file, $item, $offset);
        }
    }

    /**
     * Create array of arrays
     *
     * @param array $data
     * @param array $offset
     * @return array|void
     */
    protected function createCsvData(array $data, $offset = []): array
    {
        $items = [];
        $csvData = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $tempOffset = is_int($key) ? $offset : array_merge($offset, ['']);
                $csvData = array_merge($csvData, $this->createCsvData($value, $tempOffset));
            } else {
                $items[] = $value;
            }
        }

        $result = array_merge($offset, $items);

        if (!empty($items)) {
            array_unshift($csvData, $result);
        }

        return $csvData;
    }
}
<?php

namespace Domtake\ArrayToFileGenerator\Csv;

use Domtake\ArrayToFileGenerator\Creator;
use Domtake\ArrayToFileGenerator\File;

class CsvGenerator extends Creator
{
    private $workersArray, $path;

    public function __construct(array $workersArray, string $path)
    {
        $this->workersArray = $workersArray;
        $this->path = $path;
    }

    public function createFile(): File
    {
        return new CsvFile($this->workersArray, $this->path);
    }
}
<?php

namespace Domtake\ArrayToFileGenerator\Json;

use Domtake\ArrayToFileGenerator\Creator;
use Domtake\ArrayToFileGenerator\File;

class JsonGenerator extends Creator
{
    private $workersArray, $path;

    public function __construct(array $workersArray, string $path)
    {
        $this->workersArray = $workersArray;
        $this->path = $path;
    }

    public function createFile(): File
    {
        return new JsonFile($this->workersArray, $this->path);
    }
}
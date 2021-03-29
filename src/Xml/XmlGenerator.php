<?php

namespace Domtake\ArrayToFileGenerator\Xml;

use Domtake\ArrayToFileGenerator\Creator;
use Domtake\ArrayToFileGenerator\File;

class XmlGenerator extends Creator
{
    private $workersArray, $path;

    public function __construct(array $workersArray, string $path)
    {
        $this->workersArray = $workersArray;
        $this->path = $path;
    }

    public function createFile(): File
    {
        return new XmlFile($this->workersArray, $this->path);
    }
}
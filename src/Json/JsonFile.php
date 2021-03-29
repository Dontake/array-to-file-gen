<?php

namespace Domtake\ArrayToFileGenerator\Json;

use Domtake\ArrayToFileGenerator\File;

class JsonFile implements File
{
    private $workersArray, $path;

    public function __construct(array $workersArray, string $path)
    {
        $this->workersArray = $workersArray;
        $this->path = $path;
    }

    public function create()
    {
        $json_file = fopen($this->path, 'w');

        fwrite($json_file, json_encode($this->workersArray));

        fclose($json_file);
        echo "workers.json created successfully!";
    }
}
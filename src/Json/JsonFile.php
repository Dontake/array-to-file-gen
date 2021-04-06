<?php

namespace Domtake\ArrayToFileGenerator\Json;

use Domtake\ArrayToFileGenerator\File;
use Exception;

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
        try {
            $json_file = fopen($this->path, 'w');

            fwrite($json_file, json_encode($this->workersArray, JSON_UNESCAPED_UNICODE));

            fclose($json_file);

            echo "workers.json created successfully!";
        } catch (Exception $e) {
            // if file can't create
            echo $e->getMessage();
        }
    }
}
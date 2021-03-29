<?php

namespace Domtake\ArrayToFileGenerator;

abstract class Creator
{
    abstract public function createFile(): File;


    public function createFileFromPath()
    {
        $file = $this->createFile();

        return $file->create();
    }
}
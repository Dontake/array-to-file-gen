<?php

namespace Domtake\ArrayToFileGenerator\Xml;

use DOMDocument;
use Domtake\ArrayToFileGenerator\File;
use http\Exception;

class XmlFile implements File
{
    protected $xmlDoc, $root, $version = '1.0';

    private $workersArray, $path;


    public function __construct(array $workersArray, string $path)
    {
        $this->workersArray = $workersArray;
        $this->path = $path;

        $this->xmlDoc = new domDocument($this->version, "utf-8");

        $this->root = $this->xmlDoc->createElement("urlset");
        $this->xmlDoc->appendChild($this->root);
    }


    /**
     * Create XML document in a given directory
     * Write array of pages to this doc
     */
    public function create()
    {
        $this->xmlDoc->formatOutput = true;

        foreach ($this->workersArray as $key => $value) {
            $this->createNode($value);

            foreach ($value as $k => $v) {
                $this->createNode($v);

                foreach ($v as $a => $b) {
                    $this->createNode($b);
                }
            }
        }

        try {
            $path = $this->path;

            if (file_exists($path)) {
                unlink($path);
            }
            $this->xmlDoc->save($path);
            echo "workers.xml created successfully!";

        } catch (Exception $e) {
            echo 'Сan\'t create here!', $e->getMessage(), "\n";
        }
    }

    /**
     * Create node of xml document
     *
     * @param array $page array of values $page_array
     */
    protected function createNode(array $page)
    {
        $url = $this->xmlDoc->createElement("url");
        $this->root->appendChild($url);

        foreach ($page as $key => $value) {
            $element = $this->xmlDoc->createElement($key, $value);
            $url->appendChild($element);
        }
    }
}
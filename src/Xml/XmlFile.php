<?php

namespace Domtake\ArrayToFileGenerator\Xml;

use DOMDocument;
use DOMElement;
use Domtake\ArrayToFileGenerator\File;
use http\Exception;

class XmlFile implements File
{
    protected $xmlDoc, $root, $version = '1.0';

    private $enteringArray, $path;


    public function __construct(array $enteringArray, string $path)
    {
        $this->enteringArray = $enteringArray;
        $this->path = $path;

        $this->xmlDoc = new domDocument($this->version, "utf-8");

        $this->root = $this->xmlDoc->createElement("doc");
        $this->xmlDoc->appendChild($this->root);
    }


    /**
     * Create XML document in a given directory
     * Write array of pages to this doc
     */
    public function create()
    {
        $this->xmlDoc->formatOutput = true;

        $page = $this->createDOM($this->enteringArray);

        if ($page) {
            $this->root->appendChild($page);
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
     * @param $value
     * @param string $key
     * @return DOMElement
     */
    protected function createDOM($value, $key = 'item'): DOMElement
    {
        if (!is_array($value)) {
            return $this->xmlDoc->createElement($key, $value);
        }

        $item = $this->xmlDoc->createElement($key);

        foreach ($value as $k => $v) {
            $element = !empty($k) && !is_int($k) ? $k : 'item';
            $item->appendChild($this->createDOM($v, $element));
        }

        return $item;
    }
}
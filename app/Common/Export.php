<?php

namespace App\Common;

use SimpleXMLElement;

class Export
{
    private $data = [];
    private $type = 'text';

    public function setData(array $data = [])
    {
        $this->data = $data;
        return $this;
    }

    public function toJson()
    {
        $this->setType('json');
        return $this;
    }

    public function toXml()
    {
        $this->setType('xml');
        return $this;
    }

    public function output()
    {
        header($this->getOutputHeader());
        echo $this->formatData();
    }

    private function getOutputHeader()
    {
        $header = 'Content-Type: text/html; charset=UTF-8';

        if($this->type == 'json') {
            $header = 'Content-Type: application/json';
        } elseif($this->type == 'xml') {
            $header = 'Content-Type: application/xml';
        }

        return $header;
    }

    private function formatData()
    {
        if($this->type == 'json') {
            return json_encode($this->data);
        }

        if($this->type == 'xml') {
            return $this->getXml();
        }

        return print_r($this->data, true);
    }

    private function setType($type)
    {
        $this->type = $type;
    }

    private function getXml()
    {
        $xml = new SimpleXMLElement('<root/>');
        $this->convertArrayToXml($xml, $this->data);

        return $xml->asXML();
    }

    private function convertArrayToXml(&$xml, array $data = [], $parentKey = '')
    {
        foreach($data as $key => $value) {
            if(is_numeric($key)){
                $key = ($parentKey ? $parentKey : 'item') . $key; //dealing with <0/>..<n/> issues
            }

            if(is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->convertArrayToXml($subnode, $value, $key);
            } else {
                $xml->addChild($key, htmlspecialchars($value), $key);
            }
        }
    }
}
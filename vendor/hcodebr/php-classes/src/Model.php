<?php

namespace Hcode;

class Model {

    private $values = [];

    public function __call(string $name, array $args) {
        $method = substr($name, 0, 3);
        $fieldName = substr($name, 3, strlen($name));
        
        switch ($method) {
            case 'get':
                return $this->values[$fieldName];
            case 'set':
                $this->values[$fieldName] = $args[0];
                break;
            default:
                break;
        }
    }

    public function setData(array $data=[]) {
        foreach ($data as $attr => $value) $this->{"set$attr"} ($value);
    }

    public function getValues() : array {
        return $this->values;
    }

}
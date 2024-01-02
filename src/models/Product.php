<?php

class Product {
    public $name;
    public $id;
    public $energeticValue;
    public function __construct($id, $name, $energeticValue) {
        $this->name = $name;
        $this->id = $id;
        $this->energeticValue= $energeticValue;
    }

    // Getter and setter methods (optional)
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getID() {
        return $this->id;
    }

    public function getEnergeticValue() {
        return $this->energeticValue;
    }

    public function setEnergeticValue($energeticValue) {
        $this->energeticValue = $energeticValue;
    }
}

<?php

class Product
{
    public int $id;
    public string $name;
    public array $units = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addUnit($unit, $calories)
    {
        $this->units[$unit] = $calories;
    }

    // Getter and setter methods (optional)
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

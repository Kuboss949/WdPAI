<?php

class MealEntry
{
    private int $id;
    private string $mealName;
    private string $productName;
    private int $amount;
    private string $unit;
    private int $calories;

    /**
     * @param string $mealName
     * @param string $productName
     * @param int $amount
     * @param string $unit
     * @param int $calories
     */
    public function __construct(int $id, string $mealName, string $productName, int $amount, string $unit, int $calories)
    {
        $this->id = $id;
        $this->mealName = $mealName;
        $this->productName = $productName;
        $this->amount = $amount;
        $this->unit = $unit;
        $this->calories = $calories;
    }

    public function getMealName(): string
    {
        return $this->mealName;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getCalories(): int
    {
        return $this->calories;
    }

    public function getId(): int
    {
        return $this->id;
    }


}
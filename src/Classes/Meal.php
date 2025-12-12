<?php

namespace Radlinger\Mealplan\Classes;

use JsonSerializable;

class Meal implements JsonSerializable
{
    private int $id;
    private string $name;
    private string $allergens;
    private string $nutritionalInfo;
    private float $price;

    public function __construct(
        int    $id,
        string $name,
        string $allergens,
        string $nutritionalInfo,
        float  $price,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->allergens = $allergens;
        $this->nutritionalInfo = $nutritionalInfo;
        $this->price = $price;
    }

    // Getter
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAllergens(): string
    {
        return $this->allergens;
    }

    public function getNutritionalInfo(): string
    {
        return $this->nutritionalInfo;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "allergens" => $this->getAllergens(),
            "nutritionalInfo" => $this->getNutritionalInfo(),
            "price" => $this->getPrice(),
        ];
    }
}
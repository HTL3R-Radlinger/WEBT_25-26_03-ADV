<?php

namespace Radlinger\Mealplan\Classes;

use JsonSerializable;

class MealPlan implements JsonSerializable
{
    private int $id;
    private string $name;
    private string $schoolName;
    private string $weekOfDelivery;
    private array $meals;

    public function __construct(
        int    $id,
        string $name,
        string $schoolName,
        string $weekOfDelivery,
        array  $meals,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->schoolName = $schoolName;
        $this->weekOfDelivery = $weekOfDelivery;
        $this->meals = $meals;
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

    public function getSchoolName(): string
    {
        return $this->schoolName;
    }

    public function getWeekOfDelivery(): string
    {
        return $this->weekOfDelivery;
    }

    public function getMeals(): array
    {
        return $this->meals;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "schoolName" => $this->getSchoolName(),
            "weekOfDelivery" => $this->getWeekOfDelivery(),
            "meals" => $this->getMeals(),
        ];
    }
}

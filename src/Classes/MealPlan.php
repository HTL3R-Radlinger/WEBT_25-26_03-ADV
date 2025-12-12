<?php

namespace Radlinger\Mealplan\Classes;

use JsonSerializable;

class MealPlan implements JsonSerializable
{
    public int $id;
    public string $planName;
    public string $schoolName;
    public string $weekOfDelivery;
    public array $meals;

    public function __construct(
        int    $id,
        string $name,
        string $schoolName,
        string $weekOfDelivery,
        array  $meals,
    )
    {
        $this->id = $id;
        $this->planName = $name;
        $this->schoolName = $schoolName;
        $this->weekOfDelivery = $weekOfDelivery;
        $this->meals = $meals;
    }

    // Getter
    public function getId(): int
    {
        return $this->id;
    }

    public function getPlanName(): string
    {
        return $this->planName;
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
            "name" => $this->getPlanName(),
            "schoolName" => $this->getSchoolName(),
            "weekOfDelivery" => $this->getWeekOfDelivery(),
            "meals" => $this->getMeals(),
        ];
    }
}

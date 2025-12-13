<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\QrCode\QrCodeBuilder;
use Radlinger\Mealplan\Seeder\MealSeeder;
use Radlinger\Mealplan\View\TemplateEngine;

$mealPlans = MealSeeder::generate();

$apiLink = "http://localhost:8080/api.php?mealplanID=";

// Prepare structured array for nested loops
$data = [
    'head' => <<<HEAD
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MealPlans</title>
        <link rel="stylesheet" href="/styles/style.css">
    </head>
    HEAD,
    'header' => "All Meal Plans",
    'plans' => [],
];

foreach ($mealPlans as $plan) {
    $data['plans'][] = (object)[
        'plan_name' => $plan->name,
        'school_name' => $plan->schoolName,
        'week_of_delivery' => $plan->weekOfDelivery,
        'plan_meals' => $plan->meals,
        'qr_code' => QrCodeBuilder::generate('http://localhost:8080/api.php?mealplanID=' . $plan->id, 'MealPlan Nr.: ' . $plan->id)->getDataUri()
    ];
}

// Render the template
echo TemplateEngine::render('../templates/index.html', $data);

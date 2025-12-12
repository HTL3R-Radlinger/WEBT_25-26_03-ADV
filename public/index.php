<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\Seeder\MealSeeder;
use Radlinger\Mealplan\View\TemplateEngine;

// Generate meal plans
$mealPlans = MealSeeder::generate();

// Prepare structured data for template
$data = ['plans' => []];

foreach ($mealPlans as $plan) {
    $data['plans'][] = (object)[
        'plan_name' => $plan->getName(),
        'school_name' => $plan->getSchoolName(),
        'week_of_delivery' => $plan->getWeekOfDelivery(),
        'plan_meals' => $plan->getMeals()
    ];
}

// Render the template
echo TemplateEngine::render('../templates/index_template.html', $data);

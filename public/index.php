<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\Seeder\MealSeeder;
use Radlinger\Mealplan\View\TemplateEngine;

// Generate meal plans
$mealPlans = MealSeeder::generate();

// Prepare structured data for template
$data = [
    'plans' => [],
    'title' => 'Temp!!!!!!!!'
];
foreach ($mealPlans as $plan) {
    $data['plans'][] = [
        'plan_name' => $plan->getPlanName(),
        'school_name' => $plan->getSchoolName(),
        'week_of_delivery' => $plan->getWeekOfDelivery(),
        'plan_meals' => $plan->getMeals()
    ];
}

// Render the template
echo TemplateEngine::render('../templates/index_template.html', $data);

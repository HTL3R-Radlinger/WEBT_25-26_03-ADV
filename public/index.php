<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\Seeder\MealSeeder;
use Radlinger\Mealplan\View\TemplateEngine;

$mealPlans = MealSeeder::generate();

// Prepare structured array for nested loops
$data = [
    'plans' => [],
    'title' => "Test!!!"
];

foreach ($mealPlans as $plan) {
    $data['plans'][] = (object)[
        'plan_name' => $plan->getName(),
        'school_name' => $plan->getSchoolName(),
        'week_of_delivery' => $plan->getWeekOfDelivery(),
        'plan_meals' => $plan->getMeals()
    ];
};

// Render the template
echo TemplateEngine::render('../templates/index_template.html', $data);

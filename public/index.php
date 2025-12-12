<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\Seeder\MealSeeder;
use Radlinger\Mealplan\View\TemplateEngine;

$view = new TemplateEngine();

// Templates laden
$index_template = $view->loadTemplate('../templates/index_template.html');
$mealplan_template = $view->loadTemplate('../templates/mealplan_template.html');
$meal_template = $view->loadTemplate('../templates/meal_template.html');

$mealplans_html = "";

// render Mealplans
foreach (MealSeeder::generate() as $plan) {

    $meals_html = "";
    // render meals of the plans
    foreach ($plan->getMeals() as $meal) {
        $meals_html .= $view->render($meal_template, [
            'meal_name' => $meal->getName(),
            'meal_allergens' => $meal->getAllergens(),
            'meal_nutritionalInfo' => $meal->getNutritionalInfo(),
            'meal_price' => number_format($meal->getPrice(), 2)
        ]);
    }

    $mealplans_html .= $view->render($mealplan_template, [
        'plan_name' => $plan->getName(),
        'plan_schoolName' => $plan->getSchoolName(),
        'plan_weekOfDelivery' => $plan->getWeekOfDelivery(),
        'meals' => $meals_html
    ]);
}

$metaData = [
    'title' => <<<TITLE
    Mealplans            
    TITLE,
    'h1' => <<<H1
    MealPlans
    H1,
    'mealplans' => $mealplans_html
];

$index_template = $view->render($index_template, $metaData);

echo $index_template;

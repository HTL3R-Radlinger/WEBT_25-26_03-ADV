<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\QrCode\QrCodeBuilder;
use Radlinger\Mealplan\View\TemplateEngine;

$apiLink = "http://localhost:8080/api.php?mealplanID=";

$data = [
    'title' => "Form",
    'header' => "Generate Meal QR Code",
    'action' => htmlspecialchars($_SERVER['PHP_SELF']),
    'qr_result' => "",
    'error' => ""
];

//QrCodeBuilder::generate('http://localhost:8080/api.php?mealplanID=' . $plan->id, 'MealPlan Nr.: ' . $plan->id)->getDataUri()

//echo TemplateEngine::render('../templates/form.html', $data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mealId = trim($_POST['meal_id'] ?? '');

    if (!preg_match('/^\d+$/', $mealId)) {
        $data['error'] = '<p style="color:red">Invalid Meal ID format. (Needs to be a number)</p>';
    } else {
        $qr = QrCodeBuilder::generate('http://localhost:8080/api.php?mealplanID=' . $mealId, 'MealPlan Nr.: ' . $mealId)->getDataUri();
        $data['qr_result'] = '<img src="' . $qr . '" alt="Generated QR Code">';
    }
}

echo TemplateEngine::render('../templates/form.html', $data);
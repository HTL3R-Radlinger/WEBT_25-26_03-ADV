<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\Seeder\MealSeeder;

$mealPlans = MealSeeder::generate();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Plans Prototype</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 1rem;
        }

        .meal-plan {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin: 1rem;
            padding: 1rem;
            flex: 1 1 300px;
            max-width: 350px;
        }

        .meal-plan h2 {
            margin-top: 0;
        }

        .meal {
            border-top: 1px solid #ddd;
            padding: 0.5rem 0;
        }

        .meal:first-child {
            border-top: none;
        }

        @media (max-width: 600px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
<header>
    <h1>Meal Plans Prototype</h1>
</header>
<div class="container">
    <?php foreach ($mealPlans as $plan): ?>
        <div class="meal-plan">
            <h2><?= htmlspecialchars($plan->name) ?></h2>
            <p>School: <?= htmlspecialchars($plan->schoolName) ?> | <?= htmlspecialchars($plan->weekOfDelivery) ?></p>
            <?php foreach ($plan->meals as $meal): ?>
                <div class="meal">
                    <strong><?= htmlspecialchars($meal->name) ?></strong><br>
                    Allergens: <?= htmlspecialchars($meal->allergens) ?><br>
                    <?= htmlspecialchars($meal->nutritionalInfo) ?><br>
                    Price: €<?= htmlspecialchars(number_format($meal->price, 2)) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>

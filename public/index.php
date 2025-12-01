<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\Seeder\MealSeeder;

$mealPlans = MealSeeder::generate();


$index_template = file_get_contents('../templates/index_template.html');
$mealplans_template = file_get_contents('../templates/mealplans_template.html');
$meal_template = file_get_contents('../templates/meal_template.html');

foreach ($mealPlans as $plan) {

}

$mealplans = 'WSF';


$output = str_replace('{{mealplans}}', $mealplans, $index_template);

echo $output;
?>


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

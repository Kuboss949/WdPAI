<?php
require_once __DIR__.'/../repository/MealRepository.php';
$mealRepository = new MealRepository();
$mealEntries = $mealRepository->getMealsForUser($userObject->getId());
?>

<div class="daily-progress">
    <span class="calories-left">Calories left: <span id="left"><?php echo $userObject->getCaloriesLimit(); ?></span></span>
    <span class="daily-progress-bar">
        <?php
        for ($j = 0; $j < 5; $j++)
            for ($i = 1; $i <= 4; $i++)
                echo '<img class="gray" alt="progress-bar-img" src="../../public/images/dragon' . $i . '.png">' . PHP_EOL;

        ?>
    </span>
</div>


<div class="table">

    <?php
    $mealNames = ['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Supper'];

    // Loop through meal names and create meal-div for each
    foreach ($mealNames as $mealNameHeader):
        ?>
        <div class="meal-div">

            <div class="meal-div-header">
            <span class="meal-row">
                <h3><?php echo $mealNameHeader; ?></h3>
                <p>Calories: <span class="calories-summary">0</span></p>
            </span>
                <span>
                <img class="arrow-img" src="../../public/images/arrows.png">
            </span>
            </div>

            <?php foreach($mealEntries as $meal): ?>
                <?php if (strtolower($meal->getMealName()) === strtolower($mealNameHeader)): ?>
                    <div class="show-me product-row hide-row">
                        <span class="entry-id"><?php echo $meal->getId(); ?></span>
                    <span class="amount-and-name">
                        <span class="quantity"><?php echo $meal->getAmount(); ?></span>&nbsp;
                        <span class="unit"><?php echo $meal->getUnit(); ?></span>&nbsp;of&nbsp;
                        <span class="product-name"><?php echo $meal->getProductName(); ?></span>
                    </span>
                        <span class="calories-and-delete">
                        <span class="calories"><?php echo $meal->getAmount() * $meal->getCalories(); ?></span>kcal
                        <img class="delete-button" alt="delete" src="../../public/images/delete_button.svg">
                    </span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="show-me add-product hide-row">
                <a href="search" onclick="addProduct('<?php echo $mealNameHeader; ?>')">Add Product</a>
            </div>

        </div>

    <?php endforeach; ?>
</div>

            
        
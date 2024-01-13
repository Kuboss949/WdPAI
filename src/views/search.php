
<div class="search-bar">
    <form id="search-form" class="search-element" method="post" action="">
        <input type="search" id="search-input" name="search-input" placeholder="Search...">
    </form>
    <h1><?php echo $variables[0];  ?></h1>
    <div class="search-element"></div>
</div>
<div class="table">

</div>
<div class="product hidden">
        <span class="name-calories-span">
            <span class = "name"></span>
            <span class = "calories">Calories: <span class = "calories-value">0</span></span>
        </span>
    <span class = "choose-amount">
            <input oninput="validateInput(this)" class="amount-form amount" value="0" type="text">
            <select class="amount-form unit">
            </select>
            <button onclick="addProductToMealAndRedirect(this, <?php echo $userObject->getId() ?>, '<?php echo $variables[0]; ?>')">ADD</button>
        </span>
</div>
<script>
    const pageData = <?php echo json_encode($variables["records"]); ?>;
</script>
<h1 class="header">Stats & awards</h1>
<div class="stats-awards">
    <div class="statistics flex">
        <h2 class = "section-header">Weightloss</h2>
        <div id="chart-div">
            <canvas id="chart">
            </canvas>
        </div>
        <form class="flex" id="weight-form" method="POST" action="statistics">
            <div class="floating-label">
                <label class="form-label">Add today's weight</label>
                <input value = <?php echo $userObject->getWeight(); ?> class="form-field" type="text" name="new_weight">
            </div>
            <input type="submit" class="form-button" value="UPDATE">

        </form>
    </div>

    <div class="awards flex">
        <h2 class = "section-header">Awards</h2>
        <div class="awards-list">

            <?php foreach ($variables["rewards"] as $reward): ?>
                <div class="award flex">
                    <?php if($reward->getRequiredLevel() > $userObject->getLevel()):?>
                        <img alt="undiscovered" src="../../public/images/rewards/undiscovered.png">
                    <?php else: ?>
                        <img alt="<?php echo $reward->getRewardType(); ?>" src="../../public/images/rewards/<?php echo $reward->getRewardType(); ?>.png">
                    <?php endif; ?>
                    <span class="award-desc">
                        <?php if($reward->getRequiredLevel() > $userObject->getLevel()):?>
                        <img alt = "lock" src="../../public/images/lock.svg">
                        <?php else: ?>
                        <p> <?php echo $reward->getContent() ?></p><br>
                        <?php endif; ?>
                        <p>Level: <?php echo $reward->getRequiredLevel(); ?></p>
                    </span>
                </div>
            <?php endforeach; ?>


        </div>
    </div>

</div>
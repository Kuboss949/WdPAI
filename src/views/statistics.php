<h1 class="header">Stats & awards</h1>
<div class="stats-awards">
    <div class="statistics flex">
        <h2 class = "section-header">Weightloss</h2>
        <canvas id="chart">

        </canvas>
    </div>

    <div class="awards flex">
        <h2 class = "section-header">Awards</h2>
        <div class="awards-list">

        
        <?php 

            for ($i = 1; $i < 10; $i++) {
                echo '<div class="award flex">
                <img src="../../public/images/placeholder.jpg">
                <span class="award-desc">
                    <img src="../../public/images/lock.svg">
                    <p>Level: '.$i.'</p>
                </span>
                </div>';
            }
        ?>

        </div>
    </div>

</div>
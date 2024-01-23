
<div id="level-bar">
    <div class="level-bar-edge"></div>
    <div id="progress-bar">
        <h2>Level: <?php echo $userObject->getLevel() ?></h2>
        <progress max="100" value= <?php echo $userObject->getExp() ?>></progress>
    </div>
    <div class="profile-icon level-bar-edge">
        <a href="profile"><img alt="profile-image" src="../../public/images/profilePictures/<?php echo $userObject->getImage(); ?>.png"></a>
    </div>

</div>
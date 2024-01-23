<?php
$userObject = User::getUserFromCookie();
?>
<nav>
    <span class="logo-span">
        <img src="../../public/images/logo.png">
        <h1>NutriQuest</h1>
    </span>

    <ul>
        <li>
            <a href="myDay">
            <img src="../../public/images/castleIcon.png">
            <span>HOME</span></a>
        </li>
        <li>
            <a href="statistics">
            <img src="../../public/images/statisticsIcon.png">
            <span>STATS</span></a>
        </li>
        <?php
        if($userObject->getRole()=="admin"): ?>
            <li id="admin-panel">
                <a href="administrationPanel">
                    <img src="../../public/images/statisticsIcon.png">
                    <span>PANEL</span></a>
            </li>
        <?php endif; ?>
        <li id="profile-menu">
            <a href="profile">
                <img src="../../public/images/ProfileIcon.png">
            </a>
        </li>
        <li>
            <a href="login" id="logout">
            <img src="../../public/images/logoutIcon.png">
            <span>LOGOUT</span></a>
        </li>
    </ul>
</nav>
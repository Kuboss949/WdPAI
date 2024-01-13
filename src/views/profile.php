<h1 class="header">Profile settings</h1>
<div class="profile-grid">
    <div class="change-icon flex">
        <div class = "profile-icon">
            <img src = "../../public/images/profilePictures/<?php echo $userObject->getImage(); ?>.png">
        </div>
        <h4>Change picture</h4>
    </div>


    <div class = "profile-settings flex">
        <span class = "section-title">    
            <img src = "../../public/images/ProfileIcon.png">
            <h2>Profile</h2>
        </span>
        <form id="profile-settings-form" method="POST" action="login">
            <div class="floating-label">
                <label class="form-label">Username</label>
                <input value=<?php echo $userObject->getLogin(); ?> class="form-field" type="text" name="username" placeholder="U1">
            </div>
            <div class="floating-label">
                <label class="form-label">Email</label>
                <input value=<?php echo $userObject->getEmail(); ?> class="form-field" type="text" name="email" placeholder="U1@gmail.com">
            </div>
            <input type="submit" class="form-button" value="Apply">
        </form>
        <button class="form-button">Change password</button>
        <button class="form-button">Delete account</button>
    </div>


    <div class = "goals-settings flex">
        <span class = "section-title">
            <img src = "../../public/images/goals.png">
            <h2>Goals settings</h2>
        </span>
        <form id="goals-settings-form" method="POST" action="login">
            <div class="floating-label">
                <label class="form-label">Height</label>
                <div class="input-with-unit">
                    <input value=<?php echo $userObject->getHeight(); ?> class="form-field" type="text" name="height" placeholder="170">
                    <span class="unit">cm</span>
                </div>
            </div>
            <div class="floating-label">
                <label class="form-label">Weight</label>
                <div class="input-with-unit">
                    <input value=<?php echo $userObject->getWeight(); ?> class="form-field" type="text" name="weight" placeholder="75">
                    <span class="unit">kg</span>
                </div>
            </div>

            <div class="floating-label">
                <label class="form-label">Weekly activity</label>
                <select class="form-field"  name="weekly-activity">
                    <option value="low">Low</option>
                    <option value="average">Average</option>
                    <option value="high">High</option>
                </select>
            </div>

            <div class="floating-label">
                <label class="form-label">Weight loss</label>
                <select class="form-field"  name="weight-loss">
                    <?php
                        for ($i = 0; $i <= 6; $i++) {
                            $value = $i;
                            $text = $i * 0.1;
                            echo "<option value=\"$value\">$text kg</option>";
                        }
                    ?>
                </select>
            </div>

            <input type="submit" class="form-button" value="Apply">
        </form>
        <h2 class="daily-limit">Daily limit: 0 kcal</h2>
        
    </div>
</div>
<h1 class="header">Profile settings</h1>

<div class="profile-grid">
    <div class="change-icon flex">
        <div class="profile-icon">
            <img id="profileImage" alt="profile-image"
                 src="../../public/images/profilePictures/<?php echo $userObject->getImage(); ?>.png">
        </div>
    </div>


    <div class="profile-settings flex">
        <span class="section-title">
            <img src="../../public/images/ProfileIcon.png">
            <h2>Profile</h2>
        </span>
        <form id="profile-settings-form" method="POST" action="profile">
            <div class="floating-label">
                <label class="form-label">Login</label>
                <input value=<?php echo $userObject->getLogin(); ?> class="form-field" type="text" name="login"
                       placeholder="U1">
            </div>
            <div class="floating-label">
                <label class="form-label">Email</label>
                <input value=<?php echo $userObject->getEmail(); ?> class="form-field" type="text" name="email"
                       placeholder="U1@gmail.com">
            </div>
            <input type="hidden" name="updateProfile" value="1">
            <span class="messages">
                <?php
                if (array_key_exists("messages", $variables)) {
                    foreach ($variables['messages'] as $message) {
                        echo "<div class='message'>$message</div>";
                    }
                }
                ?>
            </span>
            <input type="submit" class="form-button" value="Apply">
        </form>
    </div>


    <div class="goals-settings flex">
        <span class="section-title">
            <img src="../../public/images/goals.png">
            <h2>Goals & preferences</h2>
        </span>
        <form id="goals-settings-form" method="POST" action="profile">
            <div class="floating-label">
                <label class="form-label">Profile picture</label>
                <select id="profilePictures" name="profilePictures" class="form-field">
                    <option value="knight" <?php echo ($userObject->getImage() == 'knight') ? 'selected' : ''; ?>>
                        Knight
                    </option>
                    <?php foreach ($variables['images'] as $image): ?>
                        <option value=<?php echo $image; ?> <?php echo ($userObject->getImage() == $image) ? 'selected' : ''; ?>>
                            <?php echo ucfirst($image); ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>
            <div class="floating-label">
                <label class="form-label">Height</label>
                <div class="input-with-unit">
                    <input value=<?php echo $userObject->getHeight(); ?> class="form-field" type="text" name="height"
                           placeholder="170">
                    <span class="unit">cm</span>
                </div>
            </div>
            <div class="floating-label">
                <label class="form-label">Weight</label>
                <div class="input-with-unit">
                    <input value=<?php echo $userObject->getWeight(); ?> class="form-field" type="text" name="weight"
                           placeholder="75">
                    <span class="unit">kg</span>
                </div>
            </div>
            <div class="floating-label">
                <label class="form-label">Age</label>
                <div class="input-with-unit">
                    <input value=<?php echo $userObject->getAge(); ?> class="form-field" type="text" name="age"
                           placeholder="20">
                    <span class="unit">years</span>
                </div>
            </div>
            <div class="floating-label">
                <label class="form-label">Sex</label>
                <select class="form-field" name="sex">
                    <option value="m" <?= ($userObject->getSex() == 'm') ? 'selected' : '' ?>>Male</option>
                    <option value="f" <?= ($userObject->getSex() == 'f') ? 'selected' : '' ?>>Female</option>
                </select>
            </div>

            <div class="floating-label">
                <label class="form-label">Weekly activity</label>
                <select class="form-field" name="weekly-activity">
                    <option value="zero" <?= ($userObject->getActivity() == 'zero') ? 'selected' : '' ?>>Zero</option>
                    <option value="low" <?= ($userObject->getActivity() == 'low') ? 'selected' : '' ?>>Low</option>
                    <option value="medium" <?= ($userObject->getActivity() == 'medium') ? 'selected' : '' ?>>Medium
                    </option>
                    <option value="high" <?= ($userObject->getActivity() == 'high') ? 'selected' : '' ?>>High</option>
                </select>
            </div>

            <div class="floating-label">
                <label class="form-label">Weight loss</label>
                <select class="form-field" name="weight-loss">
                    <?php
                    for ($i = 0; $i <= 6; $i++) {
                        $value = $i;
                        $text = $i * 0.1;
                        echo "<option value=\"$value\" " . ($userObject->getWeightLoss() == $value ? 'selected' : '') . ">$text kg</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="updateGoals" value="1">
            <input type="submit" class="form-button" value="Apply">
        </form>
        <h2 class="daily-limit">Daily limit: <?php echo $userObject->getCaloriesLimit() ?> kcal</h2>

    </div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/login.css">
    <link rel="stylesheet" href="../../public/css/global.css">
    <title>LOGIN</title>
</head>
<body>
    
    <div id="bg1"></div>
    <div id="bg2"></div>
    <span class = "logo-span">
        <img src = "../../public/images/logo.png">
        <h1>NutriQuest</h1>
    </span>
    
    <div id="login-form">
        <h1>NutriQuest</h1>
        <form id="login" method="POST" action="login">
            <div class="floating-label">
                <label class="form-label">Login/Email</label>
                <input class="form-field" type="text" name="email">
            </div>
            <div class="floating-label">
                <label class="form-label">Password</label>
                <input class="form-field" type="password" name="password">
            </div>
            <a id ="forgot" href="">Forgot password?</a>
            <input type="submit" class="form-button" value="LOGIN">
            <a href="register">&gt;&gt;Sign in&lt;&lt;</a>
            <span class="messages">
                <?php
                if (array_key_exists("messages", $variables)) {
                    foreach ($variables['messages'] as $message) {
                        echo "<div class='message'>$message</div>";
                    }
                }
                ?>
            </span>
        </form>
    </div>
    

</body>
</html>
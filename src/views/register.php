<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/login.css">
    <link rel="stylesheet" href="../../public/css/form.css">
    <link rel="stylesheet" href="../../public/css/global.css">
    <script defer type="module"  src="../../public/scripts/validationFunctions.js"></script>
    <script defer type="module"  src="../../public/scripts/loginValidation.js"></script>
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
        <form id="register" method="POST" action="register">
            <div class="floating-label">
                <label class="form-label">Email</label>
                <input placeholder="email@example.com" class="form-field" type="text" name="email">
            </div>
            <div class="floating-label">
                <label class="form-label">Login</label>
                <input placeholder="NutriKnight" class="form-field" type="text" name="login">
            </div>
            <div class="floating-label">
                <label class="form-label">Password</label>
                <input placeholder="Verystrong123" class="form-field" type="password" name="password">
            </div>
            <span class="messages">
                <?php
                if (array_key_exists("messages", $variables)) {
                    foreach ($variables['messages'] as $message) {
                        echo "<div class='message'>$message</div>";
                    }
                }
                ?>
            </span>
            <input type="submit" class="form-button" value="REGISTER">
            <a href="login">Alredy have an account?</a>

        </form>
    </div>
    

</body>
</html>
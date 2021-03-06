<?php
spl_autoload_register(function($class){
    require_once ('library/'.$class.'.php');
});

if(isset($_POST['email'])){
    $email = new EmailClass();

    $email->setAddress($_POST['email']);
    $email->insertEmail();
    header("Location: subscribe.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link type="text/css" rel="stylesheet" href="styles/styles.css">
    <script src="scripts/script.js"></script>
    <noscript>
        <meta http-equiv="refresh" content="0;url=indexNoScript.php">
    </noscript>
</head>
<body>
<div class="base">
    <div class="top-bar">
        <div class="pineapple-icon"></div>
        <div class="links">
            <a href="#" id="about">About</a>
            <a href="#" id="how-it-works">How it works</a>
            <a href="#" id="contact">Contact</a>
        </div>
    </div>
    <div class="content">
        <div class="title">Subscribe to newsletter</div>
        <div class="sub-title">Subscribe to our newsletter and get 10% discount on pineapple glasses.</div>
        <div class="input-field">
            <form method="post" action="" onsubmit="return validateForm()">
                <input type="email" id="email" name="email" placeholder="Type your email address here..." >
                <button class="icon-arrow" type="submit"></button>
                <label class="container">
                    <input type="checkbox" id="accept">
                    <span class="checkmark"></span>
                </label>
            </form>
        </div>

        <div id="error_message"></div>

        <div class="TOS">
            <span id="agree">
                <p class="i-agree-to">I agree to</p>
                <a href="#" class="terms">terms of service</a>
            </span>

            <hr class="line">
        </div>

        <div class="social-networks">
            <a href="#" class="facebook"></a>
            <a href="#" class="instagram"></a>
            <a href="#" class="twitter"></a>
            <a href="#" class="youtube"></a>
        </div>
    </div>
</div>
<div class="image"></div>
</body>
</html>

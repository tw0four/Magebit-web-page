<?php
spl_autoload_register(function($class){
    require_once ('library/'.$class.'.php');
});
$email = new EmailClass();
if(isset($_POST['submit'])){
    if(empty($_POST['email'])){
        $email->validation("Email address is required");
    }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $email->validation("Please provide a valid e-mail address");
    }else if(empty($_POST['accept'])){
        $email->validation("You must accept the terms and conditions");
    }else if(strcmp(substr($_POST['email'], strpos($_POST['email'], ".") + 1), 'co') == 0){
        $email->validation("We are not accepting subscriptions from Colombia");
    }else{

        $email->setAddress($_POST['email']);
        $email->insertEmail();
        header("Location: subscribe.html");
    }
}
unset($_POST['email']);
unset($_POST['accept']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link type="text/css" rel="stylesheet" href="styles/styles.css">
</head>
<body>
<div class="base">
    <div class="top-bar">
        <div class="pineapple-icon"></div>
        <div class="links">
            <div id="about">About</div>
            <div id="how-it-works">How it works</div>
            <div id="contact">Contact</div>
        </div>
    </div>
    <div class="content">
        <div class="title">Subscribe to newsletter</div>
        <div class="sub-title">Subscribe to our newsletter and get 10% discount on pineapple glasses.</div>
        <div class="input-field">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="validation">
                <input type="email" id="email" name="email" placeholder="Type your email address here..." >
                <button class="icon-arrow" type="submit" name="submit"></button>

                <label class="container">
                    <input type="checkbox" id="accept" name="accept">
                    <span class="checkmark"></span>
                </label>
            </form>
        </div>
        <div id="error_message" name="error_message">
            <?php
                echo $email->printError();
            ?>
        </div>
        <div class="TOS">
            <span id="agree">
                <p class="i-agree-to">I agree to</p>
                <p class="terms">terms of service</p>
            </span>
            <hr class="line">
        </div>
        <div class="social-networks">
            <div class="facebook"></div>
            <div class="instagram"></div>
            <div class="twitter"></div>
            <div class="youtube"></div>
        </div>
    </div>
</div>
<div class="image"></div>
</body>
</html>

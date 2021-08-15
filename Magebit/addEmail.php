<?php
spl_autoload_register(function($class){
    require_once ('library/'.$class.'.php');
});

    $emailAddress = new EmailClass();
    $emailAddress->setAddress($_POST['email']);

    $emailAddress->insertEmail();
    header("Location: subscribe.html");
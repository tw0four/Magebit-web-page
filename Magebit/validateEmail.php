<?php

$error_message = "";

function validation($error){
    global $error_message;

    $error_message = $error;
}

function printError(){
    global $error_message;
    
    return $error_message;
}



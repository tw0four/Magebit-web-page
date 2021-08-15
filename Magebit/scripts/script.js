function validateForm(){
    var email = document.getElementById('email').value;
    var checkbox = document.getElementById('accept');


    if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email) && (email.split('.')[1] != "co") && checkbox.checked == true) {
        return true;
    }else if(email.split('.')[1] == "co"){
            document.getElementById('error_message').innerHTML = "We are not accepting subscriptions from Colombia";
            return false;
        }else if(email == ""){
            document.getElementById('error_message').innerHTML = "Email address is required";
            return false;
        }else if(checkbox.checked == false){
            document.getElementById('error_message').innerHTML = "You must accept the terms and conditions";
            return false;
        }else{
            document.getElementById('error_message').innerHTML = "Please provide a valid e-mail address";
            return false;
        }

}
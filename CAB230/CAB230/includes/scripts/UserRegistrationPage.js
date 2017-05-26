// Function for validating the elements on the user registration page
function checkValues(){
    var name = document.getElementById('name').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmPassword= document.getElementById('confirmPassword').value;
    var email= document.getElementById('email').value;
    var postcode= document.getElementById('postcode').value;
    var gender = document.getElementsByName('gender');
    var day = document.getElementById('day').value;
    var month = document.getElementById('month').value;
    var year = document.getElementById('year').value;
    
// Alerts if the name field is empty    
    if(name==""){
       document.getElementById("name").value = "Please enter a valid name";
        return false;
    }

    if(username==""){
        document.getElementById("username").value = "Please enter a valid username";
        return false;
    }
    
    //Alerts if password field is empty
    if((password=="") || (confirmPassword=="")){
        document.getElementById("password").value = "Please enter a password";
        return false;
    }
    
//  Alerts if passwords don't match
    if(password != confirmPassword){
        document.getElementById("confirmPassword").value = "Passwords don't match";
        return false;
    }
// Alerts if the email entered is in an invalid format
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
        document.getElementById("email").value = "Please enter a valid email";
        return false;
    }
// Alerts if the postcode is in an invalid format
    var regex = /^[0-9]{4}$/;
    if(regex.test(postcode)==false){
        document.getElementById("postcode").value = "Please enter a valid postcode";
        return false;
    }

    var radioChecked = false;
    for(i = 0; i < gender.length; i++) {
        if(gender[i].checked) {
            radioChecked = true;
        }
    }
    if (radioChecked == false) {
        window.alert("Please select your gender");
        return false;
    }

    if ((day == "") || (month == "") || (year == "")) {
        window.alert("Please enter your birth date");
        return false;
    }

}

function ratingCheck() {
    var rating = document.getElementsByName('rating');
    var radioChecked = false;
    for(i = 0; i < rating.length; i++) {
        if(rating[i].checked) {
            radioChecked = true;
        }
    }
    if (radioChecked == false) {
        window.alert("Please select a rating");
        return false;
    }
}
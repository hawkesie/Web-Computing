// Function for validating the elements on the user registration page
function checkValues(){
	var name = document.getElementById('name').value;
	var password = document.getElementById('password').value;
	var confirmPassword= document.getElementById('confirmPassword').value;
	var email= document.getElementById('email').value;
	var postcode= document.getElementById('postcode').value;
	
// Alerts if the name field is empty	
	if(name==""){
		window.alert("Name field is empty!");
		return false;
	}
	
	//Alerts if password field is empty
	if(password==""){
		window.alert("Password field is empty");
		return false;
	}
	
// 	Alerts if passwords don't match
	if(password != confirmPassword){
		window.alert("The passwords don't match!");
		return false;
	}
// Alerts if the email entered is in an invalid format
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
        alert("Not a valid e-mail address");
        return false;
    }
// Alerts if the postcode is in an invalid format
    var regex = /^[0-9]{4}$/;
    if(regex.test(postcode)==false){
    	window.alert("Invalid Postcode");
    	return false;
    }


}


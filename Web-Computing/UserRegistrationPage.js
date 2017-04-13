function checkValues(){
	var name = document.getElementById('name').value;
	var password = document.getElementById('password').value;
	var confirmPassword= document.getElementById('confirmPassword').value;
	if(name==""){
		window.alert("Name field is empty!");
		return false;
	}
	if(password==""){
		window.alert("Password field is empty");
		return false;
	}
	if(password != confirmPassword){
		window.alert("The passwords don't match!");
		return false;
	}

}
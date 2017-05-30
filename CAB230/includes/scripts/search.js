//Toggles every checkbox for rating as on/off if checked/unchecked
function toggle(source) {
  checkboxes = document.getElementsByClassName('rating');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

//Toggles user entry into the distance box for search by location
function locationToggle() {
	if (document.getElementById("location").readOnly == true) {
		document.getElementById("location").readOnly = false;
		requestCurrentPosition();
	} else {
		document.getElementById("location").readOnly = true;
		document.getElementById("location").value = "";
	}
}

function requestCurrentPosition() {
    if (navigator.geolocation) {
    	navigator.geolocation.getCurrentPosition(useGeoData);
    }
}

 function useGeoData(position) {
    var longitude = position.coords.longitude;
    var latitude = position.coords.latitude;
    document.getElementById("latitude").value = latitude;
    document.getElementById("longitude").value = longitude;
  }

// Function to retrieve the coordinates of the current location
function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition, showError);
	} else {
		document.getElementById("status").innerHTML="Geolocation is not supported by this browser.";
	}
}

// Function to display the coordinates and google map of the users current location
function showPosition(position) {
	document.getElementById("status").innerHTML = "Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude;	

	// display on a map
	var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=14&size=400x300&sensor=false";
	document.getElementById("mapholder").innerHTML = "<img src='"+img_url+"'>";
}

// Function to display an error if there are any issues accessing the current location
function showError(error) {
	var msg = "";
	switch(error.code) {
		case error.PERMISSION_DENIED:
			msg = "User denied the request for Geolocation."
			break;
		case error.POSITION_UNAVAILABLE:
			msg = "Location information is unavailable."
			break;
		case error.TIMEOUT:
			msg = "The request to get user location timed out."
			break;
		case error.UNKNOWN_ERROR:
			msg = "An unknown error occurred."
			break;
	}
	document.getElementById("status").innerHTML = msg;
}

//Javascript function for adding pins on the map
function initMap() {
	var myLatLng = {lat: -27.5, lng: 153};

	var map = new google.maps.Map(document.getElementById('map'), {
	  zoom: 10,
	  center: myLatLng
	});

	//For length of array given by php
	for(i = 0; i < latitudeArray.length; i++) {

		//Check each array and set coordinates based on iteration
		var myLatLng = {lat: parseFloat(latitudeArray[i]), lng: parseFloat(longitudeArray[i])};

		var marker = new google.maps.Marker({
		  position: myLatLng,
		  map: map,
		  //Check each array and set name for marker based on iteration
		  title: nameArray[i],
		  //Sets itemID to the end of URL based on iteration for clickable links
		  url:("itemPage.php?itemID=" + idArray[i])
		});
		
		//Create clickable link
		google.maps.event.addListener(marker,'click',(function(marker,i){
			return function(){
				window.location.href = marker.url;
			}
		})(marker, i));

	}
}
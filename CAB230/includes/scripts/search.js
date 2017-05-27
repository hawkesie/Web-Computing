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

		//Create clickable links
		marker.addListener('click', function() {
          window.location.href = marker.url;
        });
	}
}
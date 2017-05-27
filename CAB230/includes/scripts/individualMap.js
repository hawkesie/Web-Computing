//Function given by Google to initiate their Google Map
function initMap() {
  //Using global variables, we set values of latitude and longitude
  var myLatLng = {lat: latitude, lng: longitude};
  var map = new google.maps.Map(document.getElementById('map'), {
  zoom: 20,
  center: myLatLng
  });

  var marker = new google.maps.Marker({
  position: myLatLng,
  map: map,
  //Using global variables, we set the name of the marker to the name of the park
  title: itemName
  });

        
}

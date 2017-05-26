    

      function initMap() {
        var myLatLng = {lat: latitude, lng: longitude};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 20,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!'
        });

        
      }

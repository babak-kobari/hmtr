      function initialize() 
      {
          var lat = document.getElementById('poi_lat').value;
          var lon = document.getElementById('poi_lon').value;
//    	  var lat = 37.4419;
//    	  var lon = -122.1419;
    	  var mapOptions = 
          {
        		  center: new google.maps.LatLng(lat, lon),
        		  zoom: 13,
        		  mapTypeId: google.maps.MapTypeId.ROADMAP
          };
          var map = new google.maps.Map(document.getElementById('map_canvas'),
          mapOptions);

          var input = document.getElementById('poi_area');
          var autocomplete = new google.maps.places.Autocomplete(input);

          autocomplete.bindTo('bounds', map);

          var infowindow = new google.maps.InfoWindow();
          var marker = new google.maps.Marker({
          map: map});

        google.maps.event.addListener(autocomplete, 'place_changed', function() 
        {
          infowindow.close();
          marker.setVisible(true);
          input.className = '';
          var place = autocomplete.getPlace();
          if (!place.geometry) 
          {
            // Inform the user that the place was not found and return.
            input.className = 'notfound';
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) 
          {
            map.fitBounds(place.geometry.viewport);
          } else 
          {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          var image = new google.maps.MarkerImage
          (
              place.icon,
              new google.maps.Size(71, 71),
              new google.maps.Point(0, 0),
              new google.maps.Point(17, 34),
              new google.maps.Size(35, 35));
          marker.setIcon(image);
          marker.setPosition(place.geometry.location);

          var address = '';
          if (place.address_components) 
          {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

//          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
//          infowindow.open(map, marker);
          var latcor = place.geometry.location.lat();
          var loncor = place.geometry.location.lng();  
          document.getElementById('poi_lat').value= latcor;
          document.getElementById('poi_lon').value= loncor;
          
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) 
        {
          var radioButton = document.getElementById(id);
          google.maps.event.addDomListener(radioButton, 'click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);
      }
      google.maps.event.addDomListener(window, 'load', initialize);

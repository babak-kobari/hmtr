  
  var placeSearch,autocomplete;
  var component_form = {
    'street_number': 'short_name',
    'route': 'long_name',
    'locality': 'long_name',
    'administrative_area_level_1': 'short_name',
    'country': 'long_name',
    'postal_code': 'short_name'
  };
  
  function initialize() {
    autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), { types: [ 'geocode' ] });
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      fillInAddress();
    });
  }
  
  function fillInAddress() {
    var place = autocomplete.getPlace();
    
    for (var component in component_form) {
      document.getElementById(component).value = "";
      document.getElementById(component).disabled = false;
    }
    
    for (var j = 0; j < place.address_components.length; j++) {
      var att = place.address_components[j].types[0];
      if (component_form[att]) {
        var val = place.address_components[j][component_form[att]];
        document.getElementById(att).value = val;
      }
    }
  }
    
  function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
      });
    }
  }

  
  
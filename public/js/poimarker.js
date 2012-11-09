var map;


function initialize() {
			var lat = document.getElementById('thispoi_lat').value;
			var lon = document.getElementById('thispoi_lon').value;
            var latlng = new google.maps.LatLng(lat, lon);
            var myOptions = {
                zoom: 10,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                            
			addMarker(lat,lon,'b');



        }
        var myKey = "AIzaSyBTdIhb3x2S7P-62U2q-5EYDU1v29IyJF0";
        function loadScript() {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = "https://maps.googleapis.com/maps/api/js?key=" + myKey + "&sensor=false&callback=initialize";
            
            document.body.appendChild(script);
        }
        function addMarker(lat,lon,color) {
        	var iconcolor = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        	if (color=='b')
        		{
            	iconcolor = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
        		}
        	var location = new google.maps.LatLng(lat,lon);
        	map.setCenter(location);
        	var marker = new google.maps.Marker({
        	    position: location,
        	    icon:iconcolor,
        	    title:"Hello World!"
        	});

        	// To add the marker to the map, call setMap();
        	marker.setMap(map);
        	}

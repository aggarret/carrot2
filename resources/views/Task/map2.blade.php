<!DOCTYPE html>
<html>
  <head>
    <title>Place Autocomplete</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
    </style>
  </head>
  <body>
    <div class="pac-card" id="pac-card">
      <div>
        <div id="title">
          Autocomplete search
        </div>
        <div id="type-selector" class="pac-controls">
          <input type="radio" name="type" id="changetype-all" checked="checked">
          <label for="changetype-all">All</label>

          <input type="radio" name="type" id="changetype-establishment">
          <label for="changetype-establishment">Establishments</label>

          <input type="radio" name="type" id="changetype-address">
          <label for="changetype-address">Addresses</label>

          <input type="radio" name="type" id="changetype-geocode">
          <label for="changetype-geocode">Geocodes</label>
        </div>
        <div id="strict-bounds-selector" class="pac-controls">
          <input type="checkbox" id="use-strict-bounds" value="">
          <label for="use-strict-bounds">Strict Bounds</label>
        </div>
      </div>
      <div id="pac-container">
        <input id="pac-input" type="text"
            placeholder="See whats around you!">
      </div>
    </div>
    <div id="map"></div>
    <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div>
<script
  src="https://code.jquery.com/jquery-3.1.1.js"
  integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
  crossorigin="anonymous"></script>
    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13
        });
        var geocoder = new google.maps.Geocoder();

       
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          geocodeAddress(geocoder, map);
          console.log(calanderevents);
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);


          


          //grab calendar events from database and place in dictonary inside of array. 
      	
      	  calanderevents.map(function(event){
      	  	console.log(event["Lat"]);
      	  });

      	  //make a markers for each calendar event.
      	  

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });
      }
      
      function zipradius(calanderevents, zip) {
      	// grab zipcode from geocoder below 
      	console.log(zip);
      	//Note app must use Client-id not the app id.  Must use localhost as app or api will fail in testing 
      	//must be set to carrotpath.com during production.
      	var url = 'https://www.zipcodeapi.com/rest/js-6iaTquHqJbqfVwoSyqHuxhJGDUsRYud5NoYdSGDBR4RMBgFaGmEdEnThil9gQnmD/radius.json/'+zip+'/2/km';
      	//get Json object and retirieve the data in the oblect
      	$.getJSON(url, null, function (data){


      		
      		zipradius = [];
      		x=0;

      		console.log(data);
      		//iterate through your your data and but the zip codes in a list.
      		data.zip_codes.forEach(function(element) {
      			//place search radius 
      			zipradius[x] = parseInt(element.zip_code);
      			x += 1;
      		});
      		y=0;
      		//iterate through calander events 
      		calanderevents.forEach(function(element){
      			console.log(zipradius);
      			console.log(element.zip);
      			console.log(element.zip == zipradius[2]);
      			console.log(zipradius.includes(element.zip));
      			
      			//checks to see if element is included in list 
      			if (zipradius.includes(element.zip)){

      			}
      			else {
      				//deletes the calendar events that arnt include in the list of zp codes 
      				delete calanderevents[y];
      				
      			}
      			y += 1;
      		});

      		var markers = calanderevents.map(function(event){
      	  	    return new google.maps.Marker({
      	  		position:{lat: event["Lat"], lng: event["Lon"]},
      	  		map: map,
      	  		label: event["title"]
      	  	})
      	  });

      		//add markers to the map.
      		markers.setMap(map);
      		//calendar event output now only includes events included in the radius 
      		console.log(calanderevents);
      		console.log(data.zip_codes[1].zip_code);
      		return calanderevents;
      	} );

      }

      //in order to revieve date/Get a request we must grab it through the code below.  see Geocoder Documentation 
      function geocodeAddress(geocoder) {
      	

      	
      	//Able to grab adress from submitted imput.
        var address = document.getElementById('pac-input').value;
        //enter your adress into the GeoCode.  
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {

          	//grab calendar events from database and place in dictonary inside of array.
      	var calanderevents = [ 
      	@foreach($calanderevents as $event)
      	{ id:{{$event->id}},
      	  title: "{{$event->Event_title}}",
      	  Lat: {{$event->Lat}},
      	  Lon: {{$event->Longitude}},
      	  zip: {{$event->zip_code}} } ,
      	  @endforeach
      	  ];
          	//grab Zip Code see  https://developers.google.com/maps/documentation/geocoding/intro
             console.log(results[0].address_components[7].long_name);
             zip = results[0].address_components[7].long_name;
             zip = ""+parseInt(zip); 
             zipradius(calanderevents, zip);
             
            console.log(results[0].address_components[2].long_name);
            return calanderevents;
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqif7v2gfexClzI134YyDF793sS5ZzG7M&libraries=places&callback=initMap"
        async defer></script>
  </body>
</html>
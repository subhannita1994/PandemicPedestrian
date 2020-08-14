let map;
let circles=[];

function initMap() {

  var montreal = {lat: 45.4901945, lng: -73.6365278};
  map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: montreal});
  
  
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        map.setCenter(pos);
        fire_popular_times(pos.lat - 0.01, pos.lng - 0.01, pos.lat + 0.01, pos.lng + 0.01);

      }, function() {
        handleLocationError(true, map.getCenter());
      }, {timeout:10000});
    } else {
      handleLocationError(false, map.getCenter());
    }

    map.addListener('bounds_changed', function(){
      if(!getInformation().includes('crowd'))
        displayInformation("", true);
    })

    new AutocompleteDirectionsHandler(map);


}

function handleLocationError(browserHasGeolocation, pos) {
	console.log(browserHasGeolocation ?
	                      'Error: The Geolocation service failed/timed out' :
	                      'Error: Your browser doesn\'t support geolocation.');
  fire_popular_times(pos.lat - 0.01, pos.lng - 0.01, pos.lat + 0.01, pos.lng + 0.01);

}

/**
 * @constructor
 */
function AutocompleteDirectionsHandler(map) {
  this.map = map;
  this.originPlaceId = null;
  this.originLocation = null;
  this.destinationPlaceId = null;
  this.destinationLocation = null;
  this.travelMode = 'WALKING';
  var date = new Date();
  this.day = date.getDay();
  this.time = date.getHours();
  this.directionsService = new google.maps.DirectionsService;
  this.directionsRenderer = new google.maps.DirectionsRenderer;
  this.directionsRenderer.setMap(map);
  this.directionsRenderer.setPanel(document.getElementById('instructions'));

  var originInput = document.getElementById('place1');
  var destinationInput = document.getElementById('place2');
  var modeSelector = document.getElementById('travelMode');
  var dayInput = document.getElementById('day-selector');
  var timeInput = document.getElementById('time-selector');
  dayInput.value = this.day;
  timeInput.value = this.time;

  var originAutocomplete = new google.maps.places.Autocomplete(originInput);
  originAutocomplete.setFields(['place_id', 'geometry']);

  var destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput);
  destinationAutocomplete.setFields(['place_id', 'geometry']);

  this.setupModeListener('modeWalking', 'WALKING');
  this.setupModeListener('modeTransit', 'TRANSIT');
  this.setupModeListener('modeDriving', 'DRIVING');

  this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
  this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

  this.setupDayTimeChangedListener('day-selector', 'DAY');
  this.setupDayTimeChangedListener('time-selector', 'TIME');

}

/**

**/
AutocompleteDirectionsHandler.prototype.setupModeListener = function(
    id, mode) {
  var radioButton = document.getElementById(id);
  var me = this;

  radioButton.addEventListener('click', function() {
    me.travelMode = mode;
    if(me.originPlaceId && me.destinationPlaceId)
      me.route();
  });
};


/**
  
**/
AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(
    autocomplete, mode) {
  var me = this;
  autocomplete.bindTo('bounds', this.map);

  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    

    if (!place.place_id) {
      window.alert('Please select an option from the dropdown list.');
      return;
    }
    if (mode === 'ORIG') {
      me.originPlaceId = place.place_id;
      me.originLocation = place.geometry.location;
    } else {
      me.destinationPlaceId = place.place_id;
      me.destinationLocation = place.geometry.location;
    }
    if(me.originPlaceId && me.destinationPlaceId)
    	me.route();
  });
};


/**
  
**/
AutocompleteDirectionsHandler.prototype.setupDayTimeChangedListener = function(id, selector){

	var me = this;
	var select = document.getElementById(id);
	select.addEventListener('change', function(){
		if(selector==='DAY'){
			me.day = select.value;
		}else if(selector==='TIME'){
			me.time = select.value;
		}
		me.route();
	});
}


/**
  
**/
AutocompleteDirectionsHandler.prototype.route = function() {

  var me = this;
  if (!this.originPlaceId || !this.destinationPlaceId) {
  	var pos = this.map.getCenter();
    fire_popular_times(pos.lat()-0.01, pos.lng()-0.01, pos.lat()+0.01, pos.lng()+0.01);
    return;
  }

  this.directionsService.route(
      {
        origin: {'placeId': this.originPlaceId},
        destination: {'placeId': this.destinationPlaceId},
        travelMode: this.travelMode
      },
      (response, status) => {
        if (status === 'OK') {
          me.directionsRenderer.setDirections(response);
          if(me.originLocation!=null && me.destinationLocation!=null){
          	  if(me.originLocation.lat() < me.destinationLocation.lat())
          	    fire_popular_times(this.originLocation.lat(), this.originLocation.lng(), this.destinationLocation.lat(), this.destinationLocation.lng());
	          else
	          	fire_popular_times(this.destinationLocation.lat(), this.destinationLocation.lng(), this.originLocation.lat(), this.originLocation.lng());
          }else{
          	  var pos = this.map.getCenter();
          	  fire_popular_times(pos.lat()-0.01, pos.lng()-0.01, pos.lat()+0.01, pos.lng()+0.01);
          }
          
        } else {
          window.alert('Directions request failed due to ' + status);
        }
      });
};


/**
  
**/
function fire_popular_times(SW_lat = 45.481514, SW_lng = -73.645368, NE_lat = 45.500919, NE_lng = -73.611723){

	console.log("Finding popular times between ("+SW_lat+","+SW_lng+") and ("+NE_lat+","+NE_lng+")");
	
  displayInformation("Fetching crowd data...");

	jQuery.ajax({
		    type: "POST",
		    url: 'get_popular_times.php',
		    dataType: 'json',
		    data: {arguments: [SW_lat, SW_lng, NE_lat, NE_lng]},

		    success: function (obj, textstatus) {
		                  if( !('error' in obj) ) {
		                  	   var objects_array = JSON5.parse(obj.result);
		                       var day = document.getElementById('day-selector').value;
		                       var time = document.getElementById('time-selector').value;
		                       console.log("Day:"+day+" Time:"+time);
		                       var crowd_data = []
		                       for(var i=0;i<objects_array.length; i++){
		                       		var lat = objects_array[i].coordinates.lat;
		                       		var lng = objects_array[i].coordinates.lng;
		                       		var busy = objects_array[i].populartimes[day].data[time];
                              
		                       		crowd_data.push({
		                       			center : {lat: lat, lng:lng},
		                       			busy : busy
		                       		});
		                       }

		                       draw(crowd_data);
                           if(!map.getBounds().contains(new google.maps.LatLng(SW_lat,SW_lng)) || !map.getBounds().contains(new google.maps.LatLng(NE_lat, NE_lng)) )
                                displayInformation("",true);

		                  }
		                  else {
		                      console.log(obj.error);
		                  }
		            }
		});
    
}


/**
  
**/
function draw(crowd_data){
	// console.log(crowd_data);
	try{
		removeAllCircles();
	}catch(err){
		console.log("drawing circles for the first time! -- "+err.message);
	}
	for (var i=0;i<crowd_data.length; i++) {
	    var circle = new google.maps.Circle({
	      strokeColor: '#FF0000',
	      strokeOpacity: 0.8,
	      strokeWeight: 2,
	      fillColor: '#FF0000',
	      fillOpacity: 0.35,
	      map: map,
	      center: crowd_data[i].center,
	      radius: crowd_data[i].busy
	    });
	    circles.push(circle);
  	}
  displayInformation("");

}


/**
  
**/
function removeAllCircles(){
	for(var i in circles){
		circles[i].setMap(null);
    circles[i] = null;
	}
	circles = [];
}

/**
**/
function displayInformation(text="", fetchButton=false){
  var information = document.getElementById('information');
  information.innerHTML = text;
  if(fetchButton){
    var button = document.createElement('button');
    button.innerHTML = "Fetch Crowd Data";
    button.setAttribute('type', 'button');
    button.onclick = function(){
      var NE = map.getBounds().getNorthEast();
      var SW = map.getBounds().getSouthWest();
      fire_popular_times(SW.lat(), SW.lng(), NE.lat(), NE.lng());
    };
    information.appendChild(button);
  }
}

/**
**/
function getInformation(){
  var information = document.getElementById('information');
  return information.innerHTML;
}



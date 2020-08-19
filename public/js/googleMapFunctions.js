let map;
let circles=[];
let directionsService;
let directionsRenderer;

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

    //give option to fetch crowd data when map bounds are changed
    addBoundsListener();

    //directions service and renderer
    directionsService = new google.maps.DirectionsService;
    directionsRenderer = new google.maps.DirectionsRenderer;
    directionsRenderer.setMap(map);
    directionsRenderer.setPanel(document.getElementById('instructions'));


    //autocomplete
    var autoCompletes = [];
    jQuery.ajax({
        type: "GET",
        url: '/getSearchFields',
        success: function (placeIDs) {
                  for(index in placeIDs){
                    var element = document.getElementById(placeIDs[index]);
                    var autoComplete = new google.maps.places.Autocomplete(element);
                    autoComplete.setFields(['place_id', 'geometry']);
                    autoComplete.bindTo('bounds', map);
                    addPlacesChangedListener(autoComplete, placeIDs[index]);
                    autoCompletes.push(autoComplete);
                  }
                }
    });


}

function handleLocationError(browserHasGeolocation, pos) {
	console.log(browserHasGeolocation ?
	                      'Error: The Geolocation service failed/timed out' :
	                      'Error: Your browser doesn\'t support geolocation.');
  fire_popular_times(pos.lat - 0.01, pos.lng - 0.01, pos.lat + 0.01, pos.lng + 0.01);

}

function addBoundsListener(){
  map.addListener('bounds_changed', function(){
    if(!getInformation())
      displayInformation("", true);
  });
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

function addPlacesChangedListener(autoComplete, searchFieldID){
  autoComplete.addListener('place_changed', function() {
    var place = autoComplete.getPlace();
    if (!place.place_id) {
      window.alert('Please select an option from the dropdown list.');
      return;
    }
    jQuery.ajax({ 
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: '/updateSearchField',
      data: {
        documentID: searchFieldID, 
        placeID: place.place_id,
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng(),
        name: document.getElementById(searchFieldID).value
      },
      success: function(response){
        if('message' in response)
          console.log(response);
        else{
          var values = Object.values(response);
          route(values[0], values[1], values[2]);
        }

      },
      error: function (req, err) {
        console.log("Updating search field failed:"+err);
      }
    });
  });
}


function route(originPlaceId, destinationPlaceId, travelMode){
  directionsService.route(
      {
        origin: {'placeId': originPlaceId},
        destination: {'placeId': destinationPlaceId},
        travelMode: travelMode
      },
      (response, status) => {
        if (status === 'OK') {
          directionsRenderer.setDirections(response);
          //fire_popular_times 
        } else {
          window.alert('Directions request failed due to ' + status);
        }
      });
}



/**

**/
// AutocompleteDirectionsHandler.prototype.setupModeListener = function(
//     id, mode) {
//   var radioButton = document.getElementById(id);
//   var me = this;

//   radioButton.addEventListener('click', function() {
//     me.travelMode = mode;
//     if(me.originPlaceId && me.destinationPlaceId)
//       me.route();
//   });
// };




// /**
  
// **/
// AutocompleteDirectionsHandler.prototype.setupDayTimeChangedListener = function(id, selector){

// 	var me = this;
// 	var select = document.getElementById(id);
// 	select.addEventListener('change', function(){
// 		if(selector==='DAY'){
// 			me.day = select.value;
// 		}else if(selector==='TIME'){
// 			me.time = select.value;
// 		}
// 		me.route();
// 	});
// }



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





@extends('layouts.app')
@section('sidebar')
	<h2>The Pandemic Pedestrian</h2>
    <form>
      <div id="information"></div>	
      @foreach($documentIDs as $documentID)
      	<div class="form-group">
	    	<input type="text" class="form-control" id="{{$documentID}}" name ="{{$documentID}}" placeholder="Enter place">
	 	 </div>
      @endforeach
	 
      <div class="form-group" id="mode-selector">
          <input class="travelMode" type="radio" name="travelMode" value="WALKING" id="modeWalking" checked="checked">Walking
          <input class="travelMode" type="radio" name="travelMode" value="TRANSIT" id="modeTransit">Transit
          <input class="travelMode" type="radio" name="travelMode" value="DRIVING" id="modeDriving">Driving
      </div>
	  <div class="form-group">
          <select class="dayTime" id="day-selector">
          	@php($days = ["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"])
          	@for ($i = 0; $i < 7; $i++)
			   	     <option value="{{$i}}">{{$days[$i]}}</option>
			      @endfor
          </select>
          <select class="dayTime" id="time-selector">
          	@for($i = 0; $i < 24; $i++)
              <option value="{{$i}}">
          		@if($i < 9)
          			0{{$i}}-0{{$i+1}}
          		@elseif($i == 9)
          			0{{$i}}-{{$i+1}}
          		@else
          			{{$i}}-{{$i+1}}
          		@endif
              </option>
          	@endfor
          </select>
          <script>
            document.getElementById('day-selector').value  = "{{$selectedDay}}";
            document.getElementById('time-selector').value = "{{$selectedTime}}";
            document.querySelectorAll('.dayTime').forEach(item=>{
              item.addEventListener('change', function(){
                jQuery.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/updateDayTime',
                    dataType: 'json',
                    data: {
                      day: document.getElementById('day-selector').value,
                      time: document.getElementById('time-selector').value
                    },

                    success: function (response) {
                      fire_popular_times(map.getBounds().getSouthWest().lat(), map.getBounds().getSouthWest().lng(), map.getBounds().getNorthEast().lat(), map.getBounds().getNorthEast().lng());
                    },
                    error: function(err){
                      console.log("Failed to  update dayTime--"+err);
                    }
                });
              });
            });
            document.querySelectorAll('.travelMode').forEach(item=>{
              item.addEventListener('click', function(){
                jQuery.ajax({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                  type:"POST",
                  url:'/updateTravelMode',
                  dataType:'json',
                  data:{'travelMode':item.value},
                  success: function(response){
                    //fire_popular_times if bounds have changed or maybe let it be because bounds have changed anyway
                    if('message' in response)
                      console.log(response);
                    else{
                      var values = Object.values(response);
                      route(values[0], values[1], values[2]);
                    }
                  },
                  error: function(err){
                    console.log("Failed to update travelMode--"+err);
                  }
                });
              });
            });
            
          </script>
      </div>
	  <!-- <button type="submit" class="btn btn-primary">Go</button> -->

	</form>
    <div id="instructions"></div>
@endsection
@section('map')

@endsection

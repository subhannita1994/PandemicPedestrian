@extends('layouts.app')
@section('sidebar')
	<h2>The Pandemic Pedestrian</h2>
    <form>
      <div id="information"></div>	
	  <div class="form-group">
	    <input type="text" class="form-control" id="place1" name ="place1" placeholder="Enter source">
	  </div>
	  <div class="form-group">
	    <input type="text" class="form-control" id="place2" name ="place2" placeholder="Enter destination">
	  </div>
      <div class="form-group" id="mode-selector">
          <input type="radio" name="type" id="modeWalking" checked="checked">Walking
          <input type="radio" name="type" id="modeTransit">Transit
          <input type="radio" name="type" id="modeDriving">Driving
      </div>
	  <div class="form-group" id="day-time-selector">
          <select name="day-selector" id="day-selector">
          	@php($days = ["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"])
          	@for ($i = 0; $i < 7; $i++)
			   	<option value="{{$i}}">{{$days[$i]}}</option>
			@endfor
          </select>
          <select name="time-selector" id="time-selector">
          	@for($i = 0; $i < 24; $i++)
          		@if($i < 9)
          			<option value="{{$i}}">0{{$i}}-0{{$i+1}}</option>
          		@elseif($i == 9)
          			<option value="{{$i}}">0{{$i}}-{{$i+1}}</opion>
          		@else
          			<option value="{{$i}}">{{$i}}-{{$i+1}}</option>
          		@endif
          	@endfor
          </select>
      </div>
	  <!-- <button type="submit" class="btn btn-primary">Go</button> -->

	</form>
    <div id="instructions"></div>
@endsection
@section('map')

@endsection

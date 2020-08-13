<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>The Pandemic Pedestrian</title>
        <!--bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!--google maps-->
        <script defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap&libraries=places"></script>
        <!--google map functions -->
        <script type="text/javascript" src="{{ URL::asset('js/googleMapFunctions.js') }}"></script>
        <!--css file-->
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />
        
        </head>
    <body>

    	<table>
    		<tr>
    			<td class="sidenav">
    				<div id="sidebar">
    					@section('sidebar')
    					<h2>The Pandemic Pedestrian</h2>
	                    <form>
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
						  
						  <!-- <button type="submit" class="btn btn-primary">Go</button> -->

						</form>
                        <div id="instructions"></div>
						@show
    				</div>
    			</td>
    			<td>
    				<div id="map">
    					@yield('map')
    				</div>
    			</td>
    		</tr>
    	</table>

    </body>
</html>
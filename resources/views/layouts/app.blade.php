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
        <script defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap"></script>
        <style>
        	.sidebar{
				background-color: white;
				margin-left: 10px;
				overflow-x: visible;
				padding-top: 20px;
				height: 100%;
				width:20%;
				position: fixed;
				z-index: 1;
        	}
        	.sidenav {
			  width: 250px;
			  height: 100%;
			  background-color: white;
			  padding-top: 20px;
			  padding-left: 10px;
			  padding-right: 10px;
			}
        	table {
        	  margin: 0;
        	  padding:0;
			  height: 100%;
			  width: 100%;
			  table-layout: fixed;
			}
        	#map{
        		height: 100%;
        		width:100%;
        		margin: 0;
        		padding: 0;
        		overflow: visible;
        	}
        	html,body {
		      height: 100%;
		      width:100%;
		      margin: 0;
		      padding: 0;
		    }
        	

        </style>
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
						  
						  <button type="submit" class="btn btn-primary">Go</button>
						</form>
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
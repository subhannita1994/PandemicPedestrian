
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>The Pandemic Pedestrian</title>
        <!--bootstrap MUST GO ON TOP-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--jquery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!--google maps-->
        <script defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap&libraries=places&v=weekly"></script>
        <!--for drawing circles-->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <!--google map functions -->
        <script type="text/javascript" src="{{ URL::asset('js/googleMapFunctions.js') }}"></script>
        <!--css file-->
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />
        <!--json5 for parsing-->
        <script src="https://unpkg.com/json5@^2.0.0/dist/index.min.js"></script>
        
        </head>
    <body>

    	<table>
    		<tr>
    			<td class="sidenav">
    				<div id="sidebar">
    					@yield('sidebar')
    					
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
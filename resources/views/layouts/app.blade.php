
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
						  <div class="form-group" id="day-time-selector">
                              <select name="day-selector" id="day-selector">
                                  <option value="0">Sun</option>
                                  <option value="1">Mon</option>
                                  <option value="2">Tues</option>
                                  <option value="3">Wed</option>
                                  <option value="4">Thurs</option>
                                  <option value="5">Fri</option>
                                  <option value="6">Sat</option>
                              </select>
                              <select name="time-selector" id="time-selector">
                                  <option value="0">00-01</option>
                                  <option value="1">01-02</option>
                                  <option value="2">02-03</option>
                                  <option value="3">03-04</option>
                                  <option value="4">04-05</option>
                                  <option value="5">05-06</option>
                                  <option value="6">06-07</option>
                                  <option value="7">07-08</option>
                                  <option value="8">08-09</option>
                                  <option value="9">09-10</option>
                                  <option value="10">10-11</option>
                                  <option value="11">11-12</option>
                                  <option value="12">12-13</option>
                                  <option value="13">13-14</option>
                                  <option value="14">14-15</option>
                                  <option value="15">15-16</option>
                                  <option value="16">16-17</option>
                                  <option value="17">17-18</option>
                                  <option value="18">18-19</option>
                                  <option value="19">19-20</option>
                                  <option value="20">20-21</option>
                                  <option value="21">21-22</option>
                                  <option value="22">22-23</option>
                                  <option value="23">23-24</option>
                              </select>
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
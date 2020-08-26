# The Pandemic Pedestrian
A Laravel web application to help in social distancing using Google Maps API

This app pulls the <a href="https://support.google.com/business/answer/6263531?hl=en">popular times</a> of places (wherever available) from a <a href="https://github.com/m-wrzr/populartimes">Python library</a>.
The data is then overlayed onto the map in the form of circles with radius proportional to the crowd. 
You can set your source and destination addresses, select a day and time and see how crowded the vicinity of your route can be. 

<img src="https://github.com/subhannita1994/PandemicPedestrian/blob/master/sample%20map.png"></img>

## Prerequisites
<ul>
    <li> Composer</li>
    <li> PHP 7</li>
    <li> Python 3 and pip</li>
    <li> Google Maps API key - https://developers.google.com/places/web-service/get-api-key</li>
    <li> MySQL</li>
</ul>
       
## Installation

<ol>
    <li>Install the popular_times library - <code>pip install --upgrade git+https://github.com/m-wrzr/populartimes</code></li>
    <li>Clone this repository - <code>git clone https://github.com/subhannita1994/PandemicPedestrian.git</code></li>
    <li>Run <code>composer install</code> and <code>npm insall</code> to install the dependencies</li>
    <li>Generate an app encryption key - <code>php artisan key:generate</code></li>
    <li>Set up a MySQL database and edit the database variables accordingly in the <code>.env</code> file</li>
    <li>Migrate the database by running <code>php artisan migrate:fresh</code></li>
    <li>Run the website - <code>php artisan serv</code></li>
</ol>
    
    
    

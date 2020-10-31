<!DOCTYPE html>
<html>
  <head>
    <title>FleetComplet Task</title>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfqINq8G5VKIwgsyPKP1uIdU7ZlelqGH4" defer></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script type="text/javascript" src="public/js/fleetcomplete.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" href="public/css/style.css">
  </head>
  
  <body>
	
	<div>
		<div class="key-box">
			<input type="text" value="" name="" class="key" placeholder="api-key"/>
			<button class="button" onclick="getvehicles()">Go</button> 
		</div>
		<div class="error-section-vehicles"> Something Happend ... Please try again after some time. </div>
		<div class="loading">Loading Please Wait ...</div>
		<table class="table table-dark car-list">
		<thead>
			<tr>
				<th scope="col">Name</th>
				<th scope="col">Speed</th>
				<th scope="col">Last Update</th>
				<th scope="col">Address</th>
			</tr>
		</thead>
			<tbody class="cars"></tbody>
		</table>		
		<div class="error-section-vehicle-history"> No car route history found. </div>
		<div id="map" style="width:500px;height:500px;left:55%;top:-50px;"></div>
		<div class="car-route-section">
			<div class="route-search-box">
				<input type="text" name="daterange" value="" id="datepicker">
				<img src="public/asset/images/calender.png" height=40 id="daterange"/>
				<button class="button" onclick="getVehicleRoute()">Go</button>
			</div>
			<table class="table table-dark car-route-details">
			<thead>
				<tr>
					<th scope="col">Total Distance</th>
					<th scope="col">Number of Stops</th>
					<th scope="col">Shortest Possible distance</th>
				</tr>
			</thead>
			<tbody >
				<tr class="car-route">				
				</tr>
			</tbody>
		</table>
		</div>
	</div>
	<div id="svgload"></div>
	<div id="menu"></div>	
  </body>
</html>
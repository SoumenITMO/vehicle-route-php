var latt = [];
  var longg = [];
  var limit = 0;
  var first_latt = 0;
  var first_long = 0;
  
  $.ajax({
  type: "GET",
  headers: {  'Access-Control-Allow-Origin': '*' },
  url: "vehicleroute/home.assignment.2-1230927/187286",
  success : function( data ) {
	var parsed_data = jQuery.parseJSON(data);
	first_latt = parsed_data.vechicalroutepoints[0].lat;
	first_long = parsed_data.vechicalroutepoints[0].lng;
	
	$.each(parsed_data.vechicalroutepoints, function(index,geocode) {
		latt.push({"lat":geocode.lat, "lng":geocode.lng});
		limit++;
	});
	mapData(latt, first_latt, first_long);
  }
  });
  
 function mapData(lat, flat, flong) {
	const map = new google.maps.Map(document.getElementById("map"), {
		  zoom: 13,
		  center: { lat: flat, lng: flong },
		  mapTypeId: "terrain",
	});
	const flightPath = new google.maps.Polyline({
	  path: lat,
	  geodesic: true,
	  strokeColor: "yellow",
	  strokeOpacity: 1.0,
	  strokeWeight: 2,
	});
    flightPath.setMap(map);
}

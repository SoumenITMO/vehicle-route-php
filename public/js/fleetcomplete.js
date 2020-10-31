var key;
var objectid;
var startdate;
var enddate;

$(document).ready(function() {
  $(".car-list").hide();
  $(".cars").on("click", "tr", function() {
	 objectid = $(this).attr("object-id");
	 $(".cars tr").css("color","white");
	 $(this).css("color","red").css("font-weight",500);
	 $(".route-search-box").show();
  });
  
  $('#daterange').daterangepicker({ opens: 'left'}, function(start, end, label) {
	startdate = start.format('YYYY-MM-DD');
	enddate = end.format('YYYY-MM-DD');
    $("#datepicker").val(start.format('YYYY/MM/DD') + " - " + end.format('YYYY/MM/DD'));
  });
  $("#datepicker").val("");
});

function getVehicleRoute() {
	$("#map").hide();
	$(".loading").show();
	showRoute(objectid, startdate, enddate);
}

function showRoute(objectid, startdate, enddate) {
	
  var latt = [];
  var longg = [];
  var limit = 0;
  
  $.ajax({
  type: "GET",
  headers: {  'Access-Control-Allow-Origin': '*' },
  url: "vehicleroute/"+key+"/"+objectid+"/"+startdate+"/"+enddate,
	  success : function( vechicalroutedata ) 
	  {
		if(vechicalroutedata.response != undefined) {
			if(vechicalroutedata.response.vechicalroutepoints[0] != undefined) {
				mapdata(vechicalroutedata);
			}
			else {
				$(".error-section-vehicle-history").fadeIn(200).fadeOut(5000);
			}
		}
		else {
			$(".error-section-vehicles").fadeIn(200).fadeOut(5000);
		}
	  }
  });
}

function mapdata(carroute) {
	var carroutedetails = "";
	
	var markerIcon = {
	  url: 'public/placeholder_red.svg',
	  scaledSize: new google.maps.Size(25, 25),
	  origin: new google.maps.Point(0, 0),
	  anchor: new google.maps.Point(32,65),
	  labelOrigin: new google.maps.Point(40,33)
    };
	
	const map = new google.maps.Map(document.getElementById("map"), {
		  zoom: 13,
		  center: { lat: carroute.response.vechicalroutepoints[0].lat, lng: carroute.response.vechicalroutepoints[0].lng },
		  mapTypeId: "terrain",
	});
	
	const flightPath = new google.maps.Polyline({
	  path: carroute.response.vechicalroutepoints,
	  geodesic: true,
	  strokeColor: "yellow",
	  strokeOpacity: 1.0,
	  strokeWeight: 2,
	});
		
	new google.maps.Marker({
		map: map,
		animation: google.maps.Animation.DROP,
		position: { lat: carroute.response.vechicalroutepoints[0].lat, lng: carroute.response.vechicalroutepoints[0].lng },
		icon: markerIcon,
		label: { text: "start", color: 'yellow' }
	});
	
	new google.maps.Marker({
		map: map,
		animation: google.maps.Animation.DROP,
		position: { lat: carroute.response.vechicalroutepoints[carroute.response.vechicalroutepoints.length - 1].lat, lng: carroute.response.vechicalroutepoints[carroute.response.vechicalroutepoints.length - 1].lng },
		icon: markerIcon,
		label: { text: "end", color: 'yellow' }
	});
	
	carroutedetails += "<td>"+carroute.response.totaldistance + " km</td>";
	carroutedetails += "<td>" + carroute.response.numstops + " </td>";
	carroutedetails += "<td>" + carroute.response.shortdistance + " km </td>";
	flightPath.setMap(map);
	
	$(".car-route").html(carroutedetails);
	$(".loading").hide();
	$("#map").show();
	$(".car-route-details").show();
}

function getvehicles() {

  var htmldata = "";
  var map;
  
  var markerIcon = {
	  url: 'public/placeholder.svg',
	  scaledSize: new google.maps.Size(25, 25),
	  origin: new google.maps.Point(0, 0),
	  anchor: new google.maps.Point(32,65),
	  labelOrigin: new google.maps.Point(40,33)
  };
  
  $(".loading").show();
  $("#map").hide();
  key = $(".key").val();
  
  $.ajax({
  type: "GET",
  headers: {  'Access-Control-Allow-Origin': '*' },
  url: "vehicles/"+key,
	  success : function( vechicles ) {
		  if(vechicles.response != undefined) {
				map = new google.maps.Map(document.getElementById("map"), {
					zoom: 8,
					center: { lat: vechicles.response[0].lat, lng: vechicles.response[0].lng },
					mapTypeId: "terrain",
				});
  
			  $.each(vechicles.response, function(index, cardata) { 
				 htmldata += "<tr object-id="+cardata.objectid+">";
				 htmldata +=  " <td class='g'>"+cardata.carname+"</td> ";
				 htmldata +=  " <td>"+cardata.speed+"</td>";
				 htmldata +=  " <td>"+cardata.lastactivity+"</td>";
				 htmldata +=  " <td>"+cardata.address+"</td>";
				 htmldata += "</tr>";
				 
				 new google.maps.Marker({
					map: map,
					animation: google.maps.Animation.DROP,
					position: { lat: cardata.lat, lng: cardata.lng },
					icon: markerIcon,
					label: { text: cardata.carname, color: 'yellow' }
				 });
			  });
			  $(".cars").html(htmldata);
			  $(".loading").hide();
			  $("#map").show();
			  $(".car-list").show();
		  }		
		  else {
		    $(".error-section-vehicles").fadeIn(200).fadeOut(5000);
		  }
		  
	  }
  });
}
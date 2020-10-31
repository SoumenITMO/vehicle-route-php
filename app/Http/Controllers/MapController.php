<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function getVehicleRoute($key, $objectId, $startdate, $enddate) 
	{
		$flag = 0;
		$numStops = 0;
		$totalDistance = 0;
		$routePoints = array();
		$lastDistanceOnWay = 0;
		$shortDistance = 0;
		
		$getVechicalsHistoryData = @file_get_contents("https://app.ecofleet.com/seeme/Api/Vehicles/getRawData?objectId=".$objectId.
		"&begTimestamp=".$startdate."&endTimestamp=".$enddate."&key=".$key."&json");
		
		if(isset(json_decode($getVechicalsHistoryData)->response)) {
			$getVechicalsHistoryDataResponse = json_decode($getVechicalsHistoryData)->response;
			$totalDistance = $getVechicalsHistoryDataResponse[sizeof($getVechicalsHistoryDataResponse)-1]->Distance - $getVechicalsHistoryDataResponse[0]->Distance;
			if(isset($getVechicalsHistoryDataResponse) > 0) {
   			    foreach($getVechicalsHistoryDataResponse as $getVechicalData) {
					array_push($routePoints, array("lat" => $getVechicalData->Latitude, "lng" => $getVechicalData->Longitude));
					if($flag == 1 && $getVechicalData->Speed == null) {
						$shortDistance += $getVechicalData->Distance - $lastDistanceOnWay;
						$numStops++;
						$flag = 0;
					}
					if($getVechicalData->Speed > 0) {
						$lastDistanceOnWay = (isset($getVechicalData->Distance) ? $getVechicalData->Distance : 0);
						$flag = 1;
					}
				}
			}
			return response()->json(array("response" => array("shortdistance" => number_format($totalDistance - $shortDistance, 0), 
			"numstops" => $numStops, "totaldistance" => number_format($totalDistance, 0), "vechicalroutepoints" => $routePoints)));
		}
		else {
			return response()->json(array("error"=>101));
		}			
	}
	
	public function getVehicles($key) 
	{
		$pathPoints = null;
		$vehicleData = array();
		$startDate = new DateTime();
		$lastActivity = null;
		
		$getVechicalsHistoryData = @file_get_contents("https://app.ecofleet.com/seeme/Api/Vehicles/getLastData?key=".$key."&json");
		if(isset(json_decode($getVechicalsHistoryData)->response)) {
			$getVechicalsHistoryDataResponse = json_decode($getVechicalsHistoryData)->response;
			foreach($getVechicalsHistoryDataResponse as $carData) {
				$lastEngineOnDate = new DateTime($carData->lastEngineOnTime);
				$interval = date_diff($startDate, $lastEngineOnDate);
				if($carData->enginestate == 0) {
					if($interval->days > 30) {
						$lastActivity = date("Y/m/d", strtotime($carData->lastEngineOnTime));
					} 
					else if($interval->h < 24 && $interval->days > 0) {
						$lastActivity = $interval->d . " days ago";
					}
					else if($interval->h < 24) {
						$lastActivity = $interval->h . " hours ago";
					}
				} 
				else {
					$lastActivity = "On the way.";
				}
				array_push($vehicleData, array("objectid" => $carData->objectId, "speed" => $carData->speed == null ? 0 : $carData->speed, "address" => $carData->address, 
				"lastactivity" => $lastActivity, "carname" => $carData->objectName, "carnumber" => $carData->plate, "lat" => $carData->latitude, "lng" => $carData->longitude));
			}		
			return response()->json(array("response" => $vehicleData));
		} 
		else {
			return response()->json(array("error" => 101));
		}
	}
	
	public function home() 
	{	
		return view("home");
	}
}

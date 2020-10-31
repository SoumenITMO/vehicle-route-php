<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ControllerTest extends TestCase
{
    public function testHomeURL()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
	
	public function testVehicleListURL()
    {
        $response = $this->get('vehicles/home.assignment.2-1230927');
		$jsonResponse = $response->getContent();
		$decodedapidata = json_decode($jsonResponse);
		$this->assertTrue(sizeof($decodedapidata->response) > 0);
    }
	
	public function testVehicleListWithWrongAPIKeyURL()
    {
        $response = $this->get('vehicles/home.assignment.1-1230927');
		$jsonResponse = $response->getContent();
		$decodedapidata = json_decode($jsonResponse);
		$this->assertTrue($decodedapidata->error == 101);
    }
	
	public function testVehicleRoute()
    {
        $response = $this->get('vehicleroute/home.assignment.2-1230927/187286/2020-10-29/2020-10-30');
		$jsonResponse = $response->getContent();
		$decodedapidata = json_decode($jsonResponse);
		$this->assertTrue(sizeof($decodedapidata->response) > 0);
    }
	
	public function testVehicleRouteNoDataWithWrongAPIKey()
    {
        $response = $this->get('vehicleroute/home.assignment.1-1230927/187286/2020-10-29/2020-10-30');
		$jsonResponse = $response->getContent();
		$decodedapidata = json_decode($jsonResponse);
		$this->assertTrue($decodedapidata->error == 101);
    }
}

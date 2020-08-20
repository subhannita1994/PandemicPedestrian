<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetSearchFieldsRoute(){
        $response = $this->get('/getSearchFields');
        $response->assertStatus(200); 
    }

    public function testUpdateSearchFieldRoute(){
        $response = $this->json('POST', '/updateSearchField', 
            ['documentID' => 'place1',
            'placeID'=> $this->generateRandomString(),
            'lat'=> $this->generateRandomFloat(),
            'lng'=> $this->generateRandomFloat(),
            'name'=> $this->generateRandomString()
        ]);
        $response->assertStatus(200);
    }

    public function testUpdateDayTimeRoute(){
        $response = $this->json('POST','/updateDayTime', 
            ['day'=> $this->generateRandomInteger(0,6),
            'time' => $this->generateRandomInteger(0,23)
        ]);
        $response->assertStatus(200)->json(['message'=>'Day and Time updated']);
    }

    public function testUpdateTravelModeRoute(){
        $response = $this->json('POST','/updateTravelMode', 
            ['travelMode'=>$this->generateRandomTravelMode()]);
        $response->assertStatus(200);  
    }




    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    private function generateRandomFloat($st_num=0,$end_num=1,$mul=1000000){
        if ($st_num>$end_num) return false;
        return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
    }
    private function generateRandomInteger($min=0, $max=100){
        if($min>$max)   return false;
        return rand($min, $max);
    }
    private function generateRandomTravelMode(){
        $input = array("WALKING", "TRANSIT", "DRIVING");
        return array_rand($input);
    }
}

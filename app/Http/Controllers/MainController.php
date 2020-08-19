<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SearchField;

class MainController extends Controller
{
    //
	protected $documentIDs;
	protected $travelMode;
	protected $day;
	protected $time;


	function __construct(){
		$this->documentIDs = [];
		$this->travelMode = 'WALKING';
		$this->day =  date('w');
		$this->time = date('G');
	}


    public function index(){
    	array_push($this->documentIDs, 'place1', 'place2');
    	SearchField::query()->truncate();
    	SearchField::create([
    		'sequence'=> 1,
    		'documentID'=>$this->documentIDs[0],
    		'name'=>null,
    		'lat'=>null,
    		'lng'=>null
    	]);
    	SearchField::create([
    		'sequence'=> 2,
    		'documentID'=>$this->documentIDs[1],
    		'name'=>null,
    		'lat'=>null,
    		'lng'=>null
    	]);
    	return view('welcome', ['documentIDs'=> $this->getSearchFieldIDs(), 
    		'selectedDay'=>$this->day,
    		'selectedTime'=>$this->time,
    		'travelMode'=>$this->travelMode
    	]);

    }

    public function getSearchFieldIDs(){
    	return DB::table('search_fields')->pluck('documentID');
    }

    public function updateSearchField(Request $request){
    	$name=$request->input('name');
		$lat=$request->input('lat');
		$lng=$request->input('lng');
		$placeID=$request->input('placeID');
		$documentID = $request->input('documentID');
		DB::table('search_fields')->where('documentID', $documentID)->update(['name'=>$name, 'lat'=>$lat, 'lng'=>$lng, 'placeID'=>$placeID]);
		return $this->showRoute();
    }

    private function showRoute(){
    	$searchFields = DB::table('search_fields')->whereNotNull('name')->get();
    	if(count($searchFields) == SearchField::count()){
    		$originPlaceID = DB::table('search_fields')->where('sequence', 1)->value('placeID');
    		$destinationPlaceID = DB::table('search_fields')->where('sequence', 2)->value('placeID');
    		return response()->json(
    			[
    				'originPlaceID'=>$originPlaceID, 
    				'destinationPlaceID'=>$destinationPlaceID,
    				'travelMode'=>$this->travelMode
    			]);
    	}
    	return response()->json(['message'=>'Not enough search fields set']);
    }

    public function updateDayTime(Request $request){
    	$this->day=$request->input('day');
    	$this->time=$request->input('time');
    	return response()->json(['message'=>'Day and Time updated']);
    }

    public function updateTravelMode(Request $request){
    	$this->travelMode = $request->input('travelMode');
    	return $this->showRoute();
    }

}

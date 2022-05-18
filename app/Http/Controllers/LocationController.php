<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
    }

    public function store (Request $request){
//        dd($request->all());
        try {
            $locations = new Location();
            $locations->user_id = auth()->id();
            $locations->long = $request->long;
            $locations->lat = $request->lat;
            $locations->name = $request->name;


            if ($locations->save()){
                return response([
                    "status" => "success",
                    "message" => "Set your pin Successfully Done"
                ]);
            }
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getall (){
//        dd($request->all());
        try {
            $locations = Location::all();


            if ($locations){
                return response([
                    "status" => "success",
                    "data" =>$locations
                ]);
            }
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ProfileVisitCount;
use Illuminate\Http\Request;

class ProfileVisitCountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store', 'show']]);
    }

    public function store (Request $request){

        try {
            $visit= new ProfileVisitCount();
            $visit->user_id = auth()->id();
            $visit->visitor_id = $request->visitor_id;


            if ($visit->save()){
                return response([
                    "status" => "success",
                    "message" => "visit Successfully Done"
                ]);
            }
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function show (Request $request){

        try {
            $visit= ProfileVisitCount::with('user')
                ->where('visitor_id', auth()->id())
                ->get();


            if ($visit){
                return response([
                    "status" => "success",
                    "data" => $visit
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

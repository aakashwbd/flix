<?php

namespace App\Http\Controllers;

use App\Models\favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store','index']]);
    }

    public function store (Request $request){
        try {
            $favourite = favourite::where('favourite_user_id', $request->favourite_user_id)->first();

            if($favourite){
                $favourite = favourite::where('favourite_user_id', $request->favourite_user_id)->delete();

                return response([
                                    "status" => "success",
                                    "message" => "User marked as unfavorite."
                                ]);
            }else{
                $favourite = new favourite();
                $favourite->user_id = auth()->id();
                $favourite->favourite_user_id = $request->favourite_user_id;


                if ($favourite->save()){
                    return response([
                                        "status" => "success",
                                        "message" => "User marked as favorite."
                                    ]);
                }
            }


        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }

    }


    public function index (){
        try {
            $favourite = favourite::with('favourite_user')
                ->where('user_id', auth()->id())->get();

            if ($favourite){
                return response([
                                    "status" => "success",
                                    "data" => $favourite
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

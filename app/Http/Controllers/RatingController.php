<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
    }

    public function store (Request $request){
        try {
            $rating = new Rating();
            $rating->user_id = auth()->id();
            $rating->video_id = $request->video_id;
            $rating->rating = $request->rating;


            if ($rating->save()){
                return response([
                                    "status" => "success",
                                    "message" => "You rated this video " . $request->rating
                                ]);
            }
        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }

    }

    function divnum($numerator, $denominator)
    {
        return $denominator == 0 ? 0 : ($numerator / $denominator);
    }


    public function count ($id){
        try {
            $videoId = $id;
            $ratingCount =  Rating::where('video_id', $videoId)->count();
            $ratingSum =  Rating::where('video_id', $videoId)->sum('rating');
            $finalRating = $this->divnum($ratingSum , $ratingCount);
            return response([
                "status" => "success",
                "data" => $finalRating
            ]);
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

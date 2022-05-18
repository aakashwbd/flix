<?php

namespace App\Http\Controllers;


use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
    }



    public function store (Request $request){
        try {

//            $user_id = request()->user('sanctum')["id"];


            $validator = Validator::make($request->all(), [
                "title" => "required",
                "address" => "required",
                "description" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $duration = [];
            if($request->duration == 'month'){
                $duration['month'] = 1;
            }
            if($request->duration == 'week'){
                $duration['week'] = 1;
            }
            if($request->duration == 'hour'){
                $duration['hour'] = 24;
            }

            $ad = new Ad();
            $ad->user_id = auth()->id();
            $ad->title = $request->title;
            $ad->address = $request->address;
            $ad->description = $request->description;
            $ad->duration = $duration;
            $ad->image = $request->image;


            if ($ad->save()){
                return response([
                    "status" => "success",
                    "message" => "A new advertisement has been created."
                ]);
            }
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update (Request $request, $id){

        try {
            $ad =   Ad::where('id', $id)->first();

            $duration = [];
            if($request->duration == 'month'){
                $duration['month'] = 1;
            }
            if($request->duration == 'week'){
                $duration['week'] = 1;
            }
            if($request->duration == 'hour'){
                $duration['hour'] = 24;
            }


            if($ad){
                $ad->title = $request->title ?? $ad->title;
                $ad->address = $request->address ?? $ad->address;
                $ad->description = $request->description ?? $ad->description;
                $ad->duration = $duration;
                $ad->image = $request->image ?? $ad->image;

                if ($ad->update()){
                    return response([
                        "status" => "success",
                        "message" => "Ads information has been updated."
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

    public function delete ($id){

        try {
            $ad =   Ad::where('id', $id)->delete();


            return response([
                                "status" => "success",
                                "message" => "The advertisement has been deleted."
                            ]);


        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAll (Request $request){
        try {
            $data = Ad::with('user')
                ->get();
//            $data = Ad::query()
//                ->get();
            return response([
                "status" => "success",
                "data" => $data
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function search (Request $request){
        try {

//                $ad = Ad::with('user')->where('address', 'LIKE', '%'.$request->address.'%')
//                    ->whereHas('user', function ($query) use($request){
//                        $query->whereBetween('age', [$request->minage, $request->maxage]);
//                    })
//                    ->get();


               $target    = Ad::leftJoin('users', 'users.id', 'ads.user_id');

               $address = $request->address;
               if (!empty($address)) {
                   $target->where(function ($query) use ($address) {
                       $query->where('ads.address', 'LIKE', '%' . $address . '%');
                   });
               }

               $preference = $request->preference;
               if (!empty($preference)) {
                   $target->where('users.preference', $preference);
               }

               $maxAge = $request->max_age;
               if (!empty($maxAge)) {
                   $target->where('users.age', '<=', (int)$maxAge);
               }

               $minAge = $request->min_age;
               if (!empty($minAge)) {
                   $target->where('users.age', '>=', (int)$minAge);
               }
//            $target->whereBetween('users.age', [$request->min_age , $request->max_age]);


               $presentation = $request->presentation;
               if (!empty($presentation)) {
                   $target->where(function ($query) use ($presentation) {
                       $query->where('users.presentation', 'LIKE', '%' . $presentation . '%');
                   });
               }

               $online = 1;
               if($request->member === 'online'){
                   $ad = Ad::with('user')
                    ->whereHas('user', function ($query) use($online){
                        $query->where('online_status', $online);
                    })
                    ->get();
                   return response([
                       "status" => "success",
                       "data" => $ad
                   ]);
               }else if($request->member === 'recent'){
                   $ad = Ad::with('user')
                       ->whereHas('user', function ($query) {
                           $query->limit(10);
                       })
                       ->get();
                   return response([
                       "status" => "success",
                       "data" => $ad
                   ]);
               }


               //end filtering

               $target = $target->with(['user'])
                   ->get();

                return response([
                    "status" => "success",
                    "data" => $target
                ]);
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

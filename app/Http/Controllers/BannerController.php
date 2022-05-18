<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index (Request $request){
        try {
            $banner = Banner::latest()->get();
            return response([
                "status" => "success",
                "data" => $banner
            ]);
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "image" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $banner = new Banner();
            $banner->image = $request->image;

            if ($banner->save()){
                return response([
                    "status" => "success",
                    "message" => "A new banner has been created."
                ]);
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
            $banner = Banner::where('id', $id)->delete();


            if ($banner){
                return response([
                    "status" => "success",
                    "message" => "Banner information has been deleted."
                ]);
            }
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSingle ($id){
        try {
            $banner = Banner::where('id', $id)->first();


            if ($banner){
                return response([
                    "status" => "success",
                    "data" => $banner
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
            $banner = Banner::where('id', $id)->first();
            if($banner){
                $banner->image = $request->image ??  $banner->image;
            }
            if ($banner->update()){
                return response([
                    "status" => "success",
                    "message" => "Banner information has been updated."
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

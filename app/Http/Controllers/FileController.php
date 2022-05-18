<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
    }
    public function store (Request $request){

        try {
            $file = new File();
            $file->user_id = auth()->id();
            $file->video = $request->video;
            $file->image = $request->image;
            $file->image_preview = $request->image_previewer;
            $file->video_preview = $request->video_previewer;
            $file->privacy = $request->privacy;
            if ($file->save()){
                return response([
                    "status" => "success",
                    "message" => "The file has been uploaded."
                ]);
            }
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getVideo (Request $request){
        try {
            $video =  File::with('user')
                ->where('privacy','public')
                ->get();

                return response([
                    "status" => "success",
                    "data" => $video
                ]);

        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchAll (Request $request){
        try {
            $all_file=  File::with('user')
                ->get();

                return response([
                    "status" => "success",
                    "data" => $all_file
                ]);

        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function singleVideo ($id){

        try {
            $video =  File::with('user')
                ->where('id',$id)
                ->first();

                return response([
                    "status" => "success",
                    "data" => $video
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
                if ($request->minage && $request->maxage){
                    $video = File::with('user')
                        ->whereHas('user', function ($query) use($request){
                            $query->whereBetween('age', [$request->minage, $request->maxage]);
                        })
                    ->get();
                return response([
                                    "status" => "success",
                                    "data" => $video
                                ]);
            } else  if($request->filter){
                $video = File::with('user')->get();

                return response([
                                    "status" => "success",
                                    "data" => $video
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

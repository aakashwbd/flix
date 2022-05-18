<?php

namespace App\Http\Controllers;

use App\Models\VideoComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
    }
    public function store (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "comment" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $comments = new VideoComment();
            $comments->user_id = auth()->id();
            $comments->video_id = $request->video_id;
            $comments->comment = $request->comment;


            if ($comments->save()){
                return response([
                                    "status" => "success",
                                    "message" => "Comment Successfully Done"
                                ]);
            }
        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }

    }

    public function show ($id){
        try {
            $comments = VideoComment::with('user')
                ->where('video_id', $id)
                ->get();

            return response([
                                "status" => "success",
                                "data" => $comments
                            ]);
        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }

    }
}

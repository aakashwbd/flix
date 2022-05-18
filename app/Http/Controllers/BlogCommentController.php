<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
    }

    public function store (Request $request){
        try {

            $validator = Validator::make($request->all(), [
                "comment_text" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }
            $blog = new BlogComment();
            $blog->user_id = auth()->id();
            $blog->blog_id = $request->blog_id;
            $blog->comment_text = $request->comment_text;


            if ($blog->save()){
                return response([
                    "status" => "success",
                    "message" => "Comment added successfully"
                ]);
            }


        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }

    }


    public function getAllComment ($id){
        try {

            $blogComment = BlogComment::with('user')
                ->where('blog_id', $id)
                ->get();

            if ($blogComment){
                return response([
                    "status" => "success",
                    "data" => $blogComment
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

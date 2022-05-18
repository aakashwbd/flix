<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class DashboardCountController extends Controller
{
    public function totalCount()
    {
        try {
            $data = [];
            $category = Category::all()->count();
            $video = Video::all()->count();
            $blog = Blog::all()->count();
            $user = User::where('user_role_id', 3)->count();
            $data[]['category'] = $category;
            $data[]['video'] = $video;
            $data[]['blog'] = $blog;
            $data[]['user'] = $user;

            return response([
                "status" => "success",
                "data" => $data
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

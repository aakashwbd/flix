<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function store (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $category = new Category();
            $category->name = $request->name;
            $category->image = $request->image;

            if ($category->save()){
                return response([
                    "status" => "success",
                    "message" => "A new category has been created.
"
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
            $category = Category::where('id', $id)->first();
            if ($category) {
                $category->name = $request->name ?? $category->name;
                $category->image = $request->image ?? $category->image;

                if ($category->update()) {
                    return response([
                        "status" => "success",
                        "message" => "Category information has been updated."
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

    public function getAll (){
        try {
            $category = Category::latest()->get();
                return response([
                    "status" => "success",
                    "data" => $category
                ]);
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function delete ($id){
        try {
            $category = Category::where('id', $id)->delete();
                return response([
                    "status" => "success",
                    "message" => 'Category Delete Successfully Done'
                ]);
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function getSingle ($id){
        try {
            $category = Category::where('id', $id)->first();
                return response([
                    "status" => "success",
                    "data" => $category
                ]);
        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


}

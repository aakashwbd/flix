<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PackageController extends Controller
{
    public function update (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "price" => "required",
                "limited" => "required",
                "unlimited" => "required",

            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $package = Package::where('id',$request->package_id)->first();
            $package->name =  $request->package_name;
            $package->list =  $request->list;
            $package->price = $request->price;
            $package->limited = $request->limited;
            $package->unlimited = $request->unlimited;

            if ($package->update()){
                return response([
                                    "status" => "success",
                                    "message" => "Package information has been updated."
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
            $package = Package::where('id',$id)->first();
            if ($package){
                return response([
                                    "status" => "success",
                                    "data" =>$package
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
            $package = Package::query()->latest()->get();

            if ($request->ajax()) {
                return Datatables::of($package)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        $button = '<button data-bs-toggle="modal" data-bs-target="#packageModal" class="btn btn-primary btn-sm text-capitalize" data-id="'.$row->id.'" onclick="packageHandler('.$row->id.')">Edit</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }


            if ($package){
                return response([
                                    "status" => "success",
                                    "data" => $package
                                ]);
            }


        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }
    }


    public function getAllPackage (){
        try {
            $package = Package::query()->latest()->get();

            if ($package){
                return response([
                    "status" => "success",
                    "data" => $package
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

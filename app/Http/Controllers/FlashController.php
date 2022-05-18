<?php

namespace App\Http\Controllers;

use App\Models\Flash;
use App\Models\UserFlash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FlashController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['sendFlash', 'getUserFlash']]);
    }
    public function store (Request $request){

        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $flash = new Flash();
            $flash->name = $request->name;


            if ($flash->save()){
                return response([
                    "status" => "success",
                    "message" => "A new flash has been created."
                ]);
            }


        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function sendFlash (Request $request){

        try {
            $flash = new UserFlash();
            $flash->sender_id = auth()->id();
            $flash->receiver_id = $request->receiver_id;
            $flash->flash_id = $request->flash;

            if ($flash->save()){
                return response([
                    "status" => "success",
                    "message" => "User flashed."
                ]);
            }


        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function show (){
        try {
            $flash = Flash::all();

            if ($flash){
                return response([
                    "status" => "success",
                    "data" => $flash
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
            $flash = Flash::where('id', $id)->delete();

            if ($flash){
                return response([
                    "status" => "success",
                    "data" => 'Flash Delete Successfully Done'
                ]);
            }

        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function singleShow ($id){
        try {
            $flash = Flash::where('id', $id)->first();

            if ($flash){
                return response([
                    "status" => "success",
                    "data" => $flash
                ]);
            }

        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUserFlash (){
        try {
            $flash = UserFlash::with('sender')
                ->where('receiver_id', auth()->id())
                ->get();

            return response([
                "status" => "success",
                "data" => $flash
            ]);

        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function allList (Request $request){

        try {
            $flash = Flash::latest()->get();

            if ($request->ajax()) {
                return Datatables::of($flash)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $button = '<button class="btn btn-primary btn-sm text-capitalize" data-id="'.$row->id.'" onclick="flashEditHandler('.$row->id.')">Edit</button>';
                        $button = $button. '<button class="btn btn-outline-secondary btn-sm text-capitalize ms-3" data-id="'.$row->id.'" onclick="flashDeleteHandler('.$row->id.')">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }


            if ($flash){
                return response([
                    "status" => "success",
                    "data" => $flash
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

            $flashData = Flash::where('id', $id)->first();
            if ($flashData) {
                $flashData->name = $request->name ?? $flashData->name;

                if ($flashData->update()) {
                    return response([
                        "status" => "success",
                        "message" => "Flash information has been updated."
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
}

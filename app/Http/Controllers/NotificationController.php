<?php

namespace App\Http\Controllers;

use App\Models\ManageNotification;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function store (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "description" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $notification = new Notification();
            $notification->title = $request->title;
            $notification->description = $request->description;
            $notification->package_id = $request->package_id;
            $notification->video_id = $request->video_id;
            $notification->link = $request->link;
            $notification->image = $request->image;



            if ($notification->save()){
                return response([
                    "status" => "success",
                    "message" => "A new notification has been send"
                ]);
            }


        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function manageApi (Request $request){
        try {
            $data = ManageNotification::first();
            if ($data){
                $data->app_id = $request->app_id ?? $data->app_id;
                $data->api_key = $request->api_key ?? $data->api_key;

                if ($data->update()) {
                    return response([
                        "status" => "success",
                        "message" => "Notification information has been updated."
                    ]);
                }
            }else{
                $validator = Validator::make($request->all(), [
                    "app_id" => "required",
                    "api_key" => "required",
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors()->messages();
                    return validateError($errors);
                }

                $notification = new ManageNotification();
                $notification->app_id = $request->app_id;
                $notification->api_key = $request->api_key;

                if ($notification->save()){
                    return response([
                        "status" => "success",
                        "message" => "A new api has been save"
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
            $notification = Notification::where('id', $id)->delete();

            if ($notification){
                return response([
                    "status" => "success",
                    "message" => "Notification Successfully Delete"
                ]);
            }


        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchManageApi (){
        try {
            $notification = ManageNotification::all();

            if ($notification){
                return response([
                    "status" => "success",
                    "data" => $notification
                ]);
            }

        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function  index(Request $request){
        $notification = Notification::query()
            ->with('package')
            ->with('video')
            ->get();
        if ($request->ajax()) {
            return Datatables::of($notification)
                ->addIndexColumn()
                ->editColumn('created_at', function($user){
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M, Y h:i:s a',);
                    return $formatedDate;
                })
                ->addColumn('action', function($row){
                    $button = '<button class="btn btn-primary btn-sm text-capitalize" data-id="'.$row->id.'" onclick="notificationDeleteHandler('.$row->id.')">Delete</button>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response([
            "status"=> 'success',
            "data"=> $notification
        ]) ;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileSetting extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store','getProfile', 'suspend', 'delete']]);
    }

    public function store (Request $request){
        try {
            $data = \App\Models\ProfileSetting::where('user_id', auth()->id())->first();

            if ($data){
                $data->alert_by_email = $request->alert_by_email ?? $data->alert_by_email;
                $data->premium_status = $request->premium_status ?? $data->premium_status;
                $data->reminder_message = $request->reminder_message ?? $data->reminder_message;
                $data->colorblind_mode = $request->colorblind_mode ?? $data->colorblind_mode;
                $data->exhibits_notification = $request->exhibits_notification ?? $data->exhibits_notification;
                $data->language = $request->language ?? $data->language;
                $data->sound_notification = $request->sound_notification ?? $data->sound_notification;

                if ($data->update()){
                    return response([
                        "status" => "success",
                        "message" => "Profile setting has been updated."
                    ]);
                }

            }else{
                $profileSetting = new \App\Models\ProfileSetting();
                $profileSetting->user_id = auth()->id();
                $profileSetting->alert_by_email = $request->alert_by_email;
                $profileSetting->premium_status = $request->premium_status;
                $profileSetting->reminder_message = $request->reminder_message;
                $profileSetting->colorblind_mode = $request->colorblind_mode;
                $profileSetting->exhibits_notification = $request->exhibits_notification;
                $profileSetting->language = $request->language;
                $profileSetting->sound_notification = $request->sound_notification;


                if ($profileSetting->save()){
                    return response([
                        "status" => "success",
                        "message" => "Profile setting has been updated."
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


    public function getProfile (){
        try {
            $profileSetting = \App\Models\ProfileSetting::where('user_id', auth()->id())->first();

            if ($profileSetting){
                return response([
                    "status" => "success",
                    "data" => $profileSetting
                ]);
            }

        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function suspend (){
        try {
            $profileSetting = User::where('id', auth()->id())->first();

            if ($profileSetting){
                $profileSetting->status = 'suspend';

                if($profileSetting->update()){
                    return response([
                        "status" => "success",
                        "message" => 'Your account suspended'
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

    public function delete (){
        try {
            $profileSetting = User::where('id', auth()->id())->delete();

            if ($profileSetting){
                return response([
                    "status" => "success",
                    "message" => 'Your account has been deleted.'
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

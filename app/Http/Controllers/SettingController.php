<?php

namespace App\Http\Controllers;

use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function store(Request $request) {
//        dd($request->all());
        try {
            $data = setting::first();

            if ($data){
                $data->system_name = $request->system_name ?? $data->system_name;
                $data->email = $request->email ?? $data->email;
                $data->web_version = $request->web_version ??  $data->web_version;
                $data->image = $request->image ?? $data->image;
                $data->copyright = $request->copyright ?? $data->copyright;
                $data->social = $request->social ??   $data->social ;
                $data->help = $request->help ??  $data->help;
                $data->age = $request->age ?? $data->age;
                $data->partner_site = $request->partner_site ?? $data->partner_site;
                $data->legal_information = $request->legal_information ?? $data->legal_information;
                if ($data->update()) {
                    return response([
                                        "status" => "success",
                                        "message" => "Update settings information"
                                    ]);
                }
            }else{
                $validator = Validator::make($request->all(), [
                    "system_name" => "required",
                    "email" => "required",
                    "copyright" => "required",
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors()->messages();
                    return validateError($errors);
                }
                $setting = new setting();
                $setting->system_name = $request->system_name;
                $setting->email = $request->email;
                $setting->web_version = $request->web_version;
                $setting->image = $request->image;
                $setting->copyright = $request->copyright;
                $setting->social = $request->social;
                $setting->help = $request->help;
                $setting->age = $request->age;
                $setting->partner_site = $request->partner_site;
                $setting->legal_information = $request->legal_information;

                if ($setting->save()) {
                    return response([
                                        "status" => "success",
                                        "message" => "Add a new settings"
                                    ]);
                }
            }




        } catch (\Exception $e) {
            return response([
                                "status" => "server_error",
                                "message" => $e->getMessage()
                            ]);
        }

    }


    public function index (){
        try {
            $setting = setting::all();
            return response([
                                "status" => "success",
                                "data" => $setting
                            ]);

        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }
    }

    public function faqSearch (Request $request){
        try {

            $users = setting::query()
                ->where('help', 'LIKE', "%{$request->search}%")
                ->get('help');

            return response([
                                "status" => "success",
                                "data" => $users
                            ]);

        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }
    }
}

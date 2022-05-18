<?php

namespace App\Http\Controllers;

use App\Models\Smtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SmtpController extends Controller
{
    public function store(Request $request) {

        try {
            $data = Smtp::first();

            if ($data){
                $data->host = $request->host ?? $data->host;
                $data->port = $request->port ?? $data->port;
                $data->username = $request->username ??  $data->username;
                $data->password = $request->password ?? $data->password;
                $data->encryption = $request->encryption ?? $data->encryption;

                if ($data->update()) {
                    return response([
                        "status" => "success",
                        "message" => "Update SMTP information"
                    ]);
                }
            }else{
                $validator = Validator::make($request->all(), [
                    "host" => "required",
                    "port" => "required",
                    "username" => "required",
                    "password" => "required",
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors()->messages();
                    return validateError($errors);
                }
                $smtp = new Smtp();
                $smtp->host = $request->host;
                $smtp->port = $request->port;
                $smtp->username = $request->username;
                $smtp->password = $request->password;
                $smtp->encryption = $request->encryption;

                if ($smtp->save()) {
                    return response([
                        "status" => "success",
                        "message" => "Add a new smtp"
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

    public function fetch(Request $request) {

        try {
            $smtp = Smtp::all();

            if ($smtp) {
                return response([
                    "status" => "success",
                    "data" => $smtp
                ]);
            }




        } catch (\Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e->getMessage()
            ]);
        }

    }
}

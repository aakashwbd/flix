<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function store (Request $request){
        try {

            $validator = Validator::make($request->all(), [
                "email" => "required",
                "subject" => "required",
                "message" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }


            $contact = new ContactUs();
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;


            if ($contact->save()){
                return response([
                                    "status" => "success",
                                    "message" => "A new message has been sent."
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

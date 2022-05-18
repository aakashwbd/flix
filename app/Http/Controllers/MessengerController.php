<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessengerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store', 'index', 'getMessage', 'getAllMessage', 'getByPersonMessage']]);
    }

    public function store(Request $request)
    {

//        dd($request->all());
        try {

            $validator = Validator::make($request->all(), [
                "message" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $message            = new Message();
            $message->from_user = auth()->id();
            $message->to_user   = $request->to_user_id;
            $message->messages  = $request->message;

            if ($message->save()) {
                return response([
                    "status"  => "success",
                    "message" => "Message Successfully Done",
                ]);
            }
        } catch (\Exception$e) {
            return response([
                'status'  => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function getMessage($id)
    {
        $messages = Message::whereIn("from_user", [auth()->id(), $id])
            ->whereIn('to_user', [$id, auth()->id()])
            ->orderBy('id', 'ASC')
            ->get();

        return response([
            "status" => "success",
            'data'   => $messages,
        ]);
    }

    public function getByPersonMessage()
    {



        $messages = Message::with('user')
            ->where("to_user", auth()->id())
            ->orWhere("from_user", auth()->id())
            ->latest()
            ->limit(5)
            ->get();

        return response([
            "status" => "success",
            'data'   => $messages,
        ]);
    }



}

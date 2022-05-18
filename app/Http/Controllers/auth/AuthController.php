<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\SendVerificationCodeMail;
use App\Models\favourite;
use App\Models\Otp;
use App\Models\Profile;
use App\Models\Smtp;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use DataTables;
use Validator;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['getAll', 'profileInfo','userOnlineStatus']]);
    }


    public function generateRandomString($length)
    {
        $characters       = '0123456789';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function register(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
                "email" => "unique:users|email:rfc,dns",
                "phone" => "unique:users",
                "password" => "required|min:6",
            ]);



            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->username = $request->username;
            $user->dob = $request->dob;
            $user->age = $request->age;
            $user->address = $request->address;
            $user->presentation = $request->presentation;
            $user->image = $request->image;
            $user->user_role_id = $request->user_role_id ?? 3;
            $user->password = Hash::make($request->password);

            if ($user->user_role_id === 3) {
                $user->status = 'pending';
            }

            $user->save();
            if ($request->user_role_id) {
                return response([
                                    "status" => "success",
                                    "form" => 'registration',
                                    "message" => "A new admin has been created."
                                ]);
            }else{
                return response([
                                    "status" => "success",
                                    "form" => 'registration',
                                    "message" => "Registration Successfully Complete"
                                ]);
            }



        } catch (Exception $e) {
            return response([
                "status" => "server_error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'email' => 'exists:users',
                'phone' => 'exists:users',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }
            if (!auth()->attempt($validator->validated())) {
                $errors = [
                    'password' => ["Password doesn't matched..."]
                ];
                return validateError($errors);
            }

            $accessToken = auth()->user()->createToken('authToken');
            return response([
                'status' => 'success',
                'message' => 'Successfully logged in...',
                'form' => 'login',
                'data' => [
                    'token' => 'Bearer ' . $accessToken->plainTextToken,
                    'user' => auth()->user(),
                ],
            ], 200);
        } catch (Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $userData = User::where('id', $id)->first();

            return response([
                "status" => "success",
                "data" => $userData
            ]);

        } catch (Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);

        }

    }

    public function statusUpdate(Request $request, $id)
    {
        try {
            $userData = User::where('id', $id)->first();

            if ($userData) {
                $userData->status = $request->status ?? $userData->status;
                if ($request->status === 'suspend') {
                    if ($userData->update()) {
                        return response([
                            "status" => "success",
                            "message" => "User has been banned.
"
                        ]);
                    }
                }
                if ($request->status === 'active') {
                    if ($userData->update()) {
                        return response([
                            "status" => "success",
                            "message" => "User has been accepted."
                        ]);
                    }
                }
            }
        } catch (Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkEmail(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)
                ->where('email', $request->email)
                ->first();

            $prevCode = Otp::where('email', $request->email)->first();

            if (!empty($prevCode)) {
                $prevCode->delete();
            }

            $code                    = new Otp;
            $code->email             = $request->email;
            $code->verification_code = $this->generateRandomString(6);
            $code->save();

            if ($code->save()) {
                $smtpSettings = Smtp::first();

                if($smtpSettings){
                    config([
                               'mail.default'                 => 'smtp',
                               'mail.mailers.smtp.host'       => $smtpSettings->host ?? '',
                               'mail.mailers.smtp.port'       => $smtpSettings->port ?? '',
                               'mail.mailers.smtp.encryption' => $smtpSettings->encryption ?? '',
                               'mail.mailers.smtp.username'   => $smtpSettings->username ?? '',
                               'mail.mailers.smtp.password'   => $smtpSettings->password ?? '',
                           ]);
                    Mail::to($request->email)->send(new SendVerificationCodeMail($code->verification_code));
                    return response([
                                        'status'            => 'success',
                                        'message'           => 'Account verification code send your email, please check your email.',
                                        "form"              => "recoverForm",
                                        'email'             => $code->email,
                                        'verification_code' => $code->verification_code,
                                    ], 200);
                }else{
                    return response([
                                        'status'  => 'error',
                                        'message' => 'Please configure your smtp server.',
                                    ], 400);
                }
            }

        } catch (Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);

        }

    }



    public function matchOTP(Request $request)
    {
        try {

            $validator = Validator::make(request()->all(), [
                'email'             => 'required|email|exists:users',
                'verification_code'              => 'required|min:6|max:6'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $code = Otp::where('email', $request->email)
                ->where('verification_code', $request->verification_code)
                ->first();


            if (empty($code)) {
                return response([
                                    'status'  => 'error',
                                    'message' => 'No code found.',
                                ], 404);
            }

            //validation expire check
            if (($code->updated_at->addHour(1)) < (now())) {
                return response([
                                    'status'  => 'error',
                                    'message' => 'Your code is expired! Please resend code.',
                                    'code' => $code->verification_code
                                ], 404);
            }

            if (($code->verification_code) == ($request->verification_code)) {
                $forgotRequest         = Otp::where('email', $request->email)->first();
                if ($forgotRequest->update()) {
                    $code->delete();
                    return response([
                                        'status'  => 'success',
                                        'form'  => 'otp_form',
                                        'message' => 'User verified. Go forword for next step.',
                                    ], 200);
                }

            }
            return response([
                                'status'  => 'error',
                                'message' => 'Code not matched',
                            ], 404);
        } catch (\Exception$e) {
            return response([
                                'status'  => 'server_error',
                                'message' => $e->getMessage(),
                            ], 500);
        }
    }

    public function userOnlineStatus(Request $request)
    {

        $user = User::where('id',auth()->id())->first();
        if ($request->status){
            $user->online_status = false;


        }else{
            $user->online_status = true;

        }

        $user->update();



    }

    public function profileInfo(Request $request)
    {
//        dd($request->all());

        try {
            $userData = User::where('id', auth()->id())->first();
            if ($userData) {
                $userData->username = $request->username ?? $userData->username;
                $userData->dob = $request->dob ?? $userData->dob;
                $userData->address = $request->address ?? $userData->address;
                $userData->test = $request->test ?? $userData->test;
                $userData->preference = $request->preference ?? $userData->preference;
                $userData->presentation = $request->presentation ?? $userData->presentation;
                $userData->image = $request->image ?? $userData->image;

                if ($userData->update()) {
                    return response([
                        "status" => "success",
                        "message" => "The profile information has been updated",
                        "user"=>$userData

                    ]);
                }
            }


        } catch (Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);

        }

    }

    public function updatePassword(Request $request)
    {

        try {
            $userData = User::where('phone', $request->phone)
                ->where('email', $request->email)
                ->first();
            if ($userData) {
                $userData->password = Hash::make($request->password) ?? $userData->password;



                if ($userData->update()) {
                    return response([
                        "status" => "success",
                        "form" => "passwordChanged",
                        "message" => "The password has been recovered."
                    ]);
                }
            }
        } catch (Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);

        }

    }

    public function getAll(Request $request)
    {

//        dd(auth()->id());
        try {
            $user = User::where('user_role_id', 3)
                ->where('id','!=', auth()->id())
                ->get();

            return response([
                "status" => "success",
                "data" => $user
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getByUnAuth(Request $request)
    {

        try {
            $user = User::where('user_role_id', 3)
                ->get();


            return response([
                "status" => "success",
                "data" => $user
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function fetchAllUser(Request $request)
    {

        try {
            $user = User::where('user_role_id', 3)
                ->get();


            return response([
                "status" => "success",
                "data" => $user
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function searchUser(Request $request)
    {

        try {
            $min = (int)$request->minage;
            $max = (int)$request->maxage;

            if($request->address){
                $user = User::where('address', 'LIKE', '%' . $request->address . '%')
                    ->get();
                return response([
                    "status" => "success",
                    "action" => "search-user",
                    "data" => $user
                ]);
            }else if($min && $max){
                $user = User::whereBetween('age', [$min, $max])
                    ->get();
                return response([
                    "status" => "success",
                    "action" => "search-user",
                    "data" => $user
                ]);
            }else if($request->member === 'all'){
                $user = User::query()
                    ->get();
                return response([
                    "status" => "success",
                    "action" => "search-user",
                    "data" => $user
                ]);
            }else if($request->member === 'new'){
                $user = User::query()
                    ->latest()
                    ->get();
                return response([
                    "status" => "success",
                    "action" => "search-user",
                    "data" => $user
                ]);
            }else if($request->member === 'online' && $request->type){

                $user = User::query()
                    ->where('online_status', 1)

                    ->get();
                return response([
                    "status" => "success",
                    "action" => "search-user",
                    "data" => $user
                ]);
            }else if($request->type){

                $user = User::where('preference', 'LIKE', '%' . $request->type . '%')->get();
                return response([
                                    "status" => "success",
                                    "action" => "search-user",
                                    "data" => $user
                                ]);
            }else if($request->keyword){
                $user = User::query()
                    ->where('presentation', 'LIKE', '%' . $request->keyword . '%')
                    ->get();
                return response([
                    "status" => "success",
                    "action" => "search-user",
                    "data" => $user
                ]);
            }else{

                $user = User::query()
                    ->get();
                return response([
                                    "status" => "success",
                                    "action" => "search-user",
                                    "data" => $user
                                ]);
            }

        } catch (\Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function index(Request $request)
    {
        $user = User::where('user_role_id', 3)->latest()->get();
        if ($request->ajax()) {
            return Datatables::of($user)
                ->addIndexColumn()
                ->editColumn('created_at', function ($user) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M, Y h:i:s a');
                    return $formatedDate;
                })
                ->addColumn('action', function ($row) {
                    $button = '';

                    if ($row->status === 'active') {
                        $button = '<button
                                        disabled
                                        id="user-accept-button"
                                        class="btn btn-primary btn-sm text-capitalize"
                                        data-id="' . $row->id . '"
                                        onclick="userHandler(' . $row->id . ')"
                                   >
                                        Accept
                                   </button>';
                    } else if ($row->status === 'suspend' || $row->status === 'pending') {
                        $button = '<button
                                            id="user-accept-button"
                                            class="btn btn-primary btn-sm text-capitalize"
                                            data-id="' . $row->id . '"
                                            onclick="userHandler(' . $row->id . ')"
                                       >
                                            Accept
                                       </button>';
                    }

                    if ($row->status === 'suspend') {
                        $button = $button . '<button
                                                    disabled
                                                    class="btn btn-outline-secondary btn-sm text-capitalize ms-3"
                                                    data-id="' . $row->id . '"
                                                    onclick="userBannedHandler(' . $row->id . ')"
                                                >
                                                    banned
                                                </button>';
                    } else if ($row->status === 'active' || $row->status === 'pending') {
                        $button = $button . '<button
                                                    class="btn btn-outline-secondary btn-sm text-capitalize ms-3"
                                                    data-id="' . $row->id . '"
                                                    onclick="userBannedHandler(' . $row->id . ')"
                                                >
                                                    banned
                                                </button>';
                    }

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response([
            "status" => 'success',
            "data" => $user
        ]);
    }
    public function getAllUsers(Request $request)
    {
        $user = User::where('user_role_id', 3)->latest()->get();
        if ($request->ajax()) {
            return Datatables::of($user)
                ->addIndexColumn()
                ->editColumn('created_at', function ($user) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M, Y h:i:s a');
                    return $formatedDate;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response([
            "status" => 'success',
            "data" => $user
        ]);
    }

    public function suspendUser(Request $request)
    {
        $user = User::where('user_role_id', 3)
            ->where('status', 'suspend')
            ->latest()
            ->get();
        if ($request->ajax()) {
            return Datatables::of($user)
                ->addIndexColumn()
                ->editColumn('created_at', function ($user) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M, Y h:i:s a');
                    return $formatedDate;
                })
                ->addColumn('action', function ($row) {
                    $button = '<button class="btn btn-primary btn-sm text-capitalize" data-id="' . $row->id . '" onclick="userHandler(' . $row->id . ')">Accept</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response([
            "status" => 'success',
            "data" => $user
        ]);
    }


}

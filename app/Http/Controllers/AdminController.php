<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Yajra\DataTables\Facades\DataTables;

    class AdminController extends Controller {
        public function __construct() {
            $this->middleware(['auth:sanctum'], ['only' => ["updatePassword", "profileUpdate"]]);
        }

        public function index(Request $request) {
            $user = User::query()
                ->where('user_role_id', '!=', 3)
                ->get();

            if ($request->ajax()) {
                return Datatables::of($user)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($user) {
                        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M, Y h:i:s a',);
                        return $formatedDate;
                    })
                    ->addColumn('action', function ($row) {
                                            $button = '<button class="btn btn-primary btn-sm" onclick="adminEditHandler('.$row->id.')" data-id="'.$row->id.'">Edit</button>';
                        $button =$button. '<button class="btn btn-outline-secondary btn-sm ms-3" onclick="adminDeleteHandler(' . $row->id . ')" data-id="' . $row->id . '">Delete</button>';
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

        public function delete($id) {
            try {
                $admin = User::where('id', $id)->delete();
                return response([
                                    "status" => "success",
                                    "message" => 'Admin Delete Successfully Done'
                                ]);
            } catch (\Exception $e) {
                return response([
                                    'status' => 'serverError',
                                    'message' => $e->getMessage(),
                                ], 500);
            }
        }

        public function getSingle($id) {
            try {
                $admin = User::where('id', $id)->first();
                return response([
                                    "status" => "success",
                                    "data" => $admin
                                ]);
            } catch (\Exception $e) {
                return response([
                                    'status' => 'serverError',
                                    'message' => $e->getMessage(),
                                ], 500);
            }
        }

        public function update(Request $request,$id) {

            try {
                $data = User::where('id', $id)->first();

                $data->name = $request->name ?? $data->name;
                $data->user_role_id = $request->user_role_id ?? $data->user_role_id;

                if($data->update()){


                    return response([
                        "status" => "success",
                        "message" => 'Admin information has been updated.'
                    ]);
                }

            } catch (\Exception $e) {
                return response([
                                    'status' => 'serverError',
                                    'message' => $e->getMessage(),
                                ], 500);
            }
        }

        public function updatePassword(Request $request) {
            try {
                $userData = User::where('id', auth()->id())->first();

                $validator = Validator::make($request->all(), [
                    "password" => "required|min:6"
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors()->messages();
                    return validateError($errors);
                }

                if ($userData) {
                    $userData->password = Hash::make($request->password) ?? $userData->password;

                    if ($userData->update()) {
                        return response([
                                            "status" => "success",
                                            "form" => "passwordChanged",
                                            "message" => "The password has been updated."
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


        public function profileUpdate(Request $request) {
            //        dd($request->all());

            try {
                $userData = User::where('id', auth()->id())->first();
                if ($userData) {
                    $userData->name = $request->name ?? $userData->name;
                    $userData->phone = $request->phone ?? $userData->phone;
                    $userData->image = $request->image ?? $userData->image;

                    if ($userData->update()) {
                        return response([
                                            "status" => "success",
                                            "message" => "The profile information has been updated",
                                            "user" => $userData

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
    }

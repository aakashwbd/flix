<?php

namespace App\Http\Controllers;

use App\Models\InviteCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InviteCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['getByUser']]);
    }
    public function store (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "user_id" => "required",
                "package_id" => "required",
                "duration" => "required",
                "reduction" => "required",
                "price" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }


            $invite = new InviteCode();
            $invite->title = $request->title;
            $invite->user_id = $request->user_id;
            $invite->package_id = $request->package_id;
            $invite->duration = $request->duration;
            $invite->reduction = $request->reduction;
            $invite->price = $request->price;


            if ($invite->save()){
                return response([
                    "status" => "success",
                    "message" => "A new invite code has been generated"
                ]);
            }


        }catch (\Exception $e){
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function index (Request $request){
        try {
            $invite = InviteCode::with('user')
                ->with('package')
                ->get();

            if ($request->ajax()) {
                return Datatables::of($invite)
                    ->addIndexColumn()

                    ->addColumn('action', function($row){
                        $button = '<button data-bs-toggle="modal" data-bs-target="#editInviteModal" class="btn btn-primary btn-sm"  onclick="codeEditHandler('.$row->id.')">Edit</button>';

                        $button = $button.  '<button  class="btn btn-outline-secondary btn-sm ms-3" onclick="inviteCodeDeleteHandler('.$row->id.')">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }


            if ($invite){
                return response([
                                    "status" => "success",
                                    "data" => $invite
                                ]);
            }


        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }
    }

    public function getByUser (Request $request){
        try {
            $invite = InviteCode::with('package')
                ->where('user_id', auth()->id())
                ->get();

            if ($invite){
                return response([
                                    "status" => "success",
                                    "data" => $invite
                                ]);
            }


        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }
    }


    public function getSingleCode ($id){
        try {
            $invite = InviteCode::with('package')
                ->with('user')
                ->where('id', $id)
                ->first();

            if ($invite){
                return response([
                                    "status" => "success",
                                    "data" => $invite
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
            $invite = InviteCode::where('id', $id)->first();

            if($invite){

                $invite->title = $request->title ??  $invite->title;
                $invite->duration = $request->duration ?? $invite->duration;
                $invite->reduction = $request->reduction ?? $invite->reduction ;
                $invite->price = $request->price ??   $invite->price;
            }
            if ($invite->update()){
                return response([
                                    "status" => "success",
                                    "message" => "Generate code information has been updated."
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
            $flash = InviteCode::where('id', $id)->delete();

            if ($flash){
                return response([
                                    "status" => "success",
                                    "data" => 'Generate code Delete Successfully Done'
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

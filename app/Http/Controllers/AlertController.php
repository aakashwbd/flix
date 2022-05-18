<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AlertController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
    }

    public function store (Request $request){

        try {
            $validator = Validator::make($request->all(), [
                "message" => "required",
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
                return validateError($errors);
            }

            $alert= new Alert();
            $alert->user_id = auth()->id();
            $alert->reported_user_id = $request->reported_user_id;
            $alert->reports = $request->reports;
            $alert->message = $request->message;


            if ($alert->save()){
                return response([
                                    "status" => "success",
                                    "message" => "User alerted."
                                ]);
            }
        }catch (\Exception $e){
            return response([
                                'status' => 'serverError',
                                'message' => $e->getMessage(),
                            ], 500);
        }

    }

    public function getAll (Request $request){
        try {
            $alert= Alert::with('user')
                ->with('reported_user')
            ->get();

            if ($request->ajax()) {
                return Datatables::of($alert)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($user){
                        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M, Y h:i:s a',);
                        return $formatedDate;
                    })
//                    ->addColumn('action', function($row){
//                        $button = '<button class="btn btn-primary rounded-0 text-capitalize" data-id="'.$row->id.'" onclick="flashEditHandler('.$row->id.')">Edit</button>';
//                        $button = $button. '<button class="btn btn-outline-primary rounded-0 text-capitalize ms-3" data-id="'.$row->id.'" onclick="flashDeleteHandler('.$row->id.')">Delete</button>';
//                        return $button;
//                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            if ($alert){
                return response([
                                    "status" => "success",
                                    "data" => $alert
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

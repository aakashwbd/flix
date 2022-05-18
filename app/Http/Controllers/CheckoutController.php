<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
    }

    public function store(Request $request)
    {


        try {
            $checkout = new Checkout();
            $checkout->user_id = auth()->id();
            $checkout->package_id = $request->id;
            $checkout->package_name = $request->name;
            $checkout->package_price = $request->price;

            if ($checkout->save()) {
                return response([
                    "status" => "success",
                    "message" => "Package Successfully Save"
                ]);
            }


        } catch (\Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function getAllCheckoutList(Request $request)
    {
        try {

            $data = Checkout::query()
                ->with('user')
                ->with('package')
                ->get();

            if ($request->ajax()) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($user){
                        $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M, Y h:i:s a',);
                        return $formatedDate;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return response([
                "status" => "success",
                "data" => $data
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function allSubcribeUser(Request $request)
    {
        try {
            $checkout = Checkout::with('user')
                ->latest()
                ->get();

            return response([
                "status" => "success",
                "data" => $checkout
            ]);
        } catch (\Exception $e) {
            return response([
                'status' => 'serverError',
                'message' => $e->getMessage(),
            ], 500);
        }

    }
}

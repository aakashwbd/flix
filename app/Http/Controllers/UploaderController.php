<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploaderController extends Controller
{
    public function imgUploader(Request $request)
    {
//        dd($request->all());
        $validate = Validator::make(request()->only('file'), [
            'file' => 'required|max:100040',
        ]);
        if ($validate->fails()) {
            return response([
                                'status' => 'validation_error',
                                'data'   => $validate->errors(),
                            ], 422);
        }
        try {
            if (request()->has('file')) {
                $folder    = $request->folder ?? 'all';
                $image     = $request->file('file');
                $imageName = $folder . "/" . time() . '.' . $image->getClientOriginalName();
                if (config('app.env') === 'production') {
                    $image->move('uploads/' . $folder, $imageName);
                } else {
                    $image->move(public_path('/uploads/' . $folder), $imageName);
                }
                $protocol = request()->secure();
                return response([
                                    'status'  => 'success',
                                    'message' => 'File uploaded successfully',
                                    'data'    => $protocol ? 'https://'. $_SERVER['HTTP_HOST'] . '/public/uploads/' . $imageName : 'http://' . $_SERVER['HTTP_HOST'] . '/uploads/' . $imageName,
                                ], 200);
            }
        } catch (\Exception$e) {
            return response([
                                'status'  => 'server_error',
                                'message' => $e->getMessage(),
                            ], 500);
        }
    }
//    public function imgUploader(Request $request)
//    {
//              dd($request->all());
//        $validate = Validator::make(request()->only('file'), [
//            'file' => 'required|max:10240',
//        ]);
//        if ($validate->fails()) {
//            return response([
//                                'status' => 'validation_error',
//                                'data'   => $validate->errors(),
//                            ], 422);
//        }
//        try {
//            if (request()->hasFile('file')) {
//
//
//                foreach ($request->file('file') as $imagedata){
//
//                    $folder    = $request->folder ?? 'all';
//                    $imageName = $folder . "/" . time() . '.' . $imagedata->getClientOriginalName();
//                    if (config('app.env') === 'production') {
//                        $imagedata->move('uploads/' . $folder, $imageName);
//                    } else {
//                        $imagedata->move(public_path('/uploads/' . $folder), $imageName);
//                    }
//                    $protocol = request()->secure() ? 'https://' : 'http://';
//                    $mainProtocol = $protocol . $_SERVER['HTTP_HOST'] . '/uploads/' . $imageName;
//                    $data[] = $mainProtocol;
//                }
//                $finalImage = json_encode($data);
//
//                return response([
//                                    'status'  => 'success',
//                                    'message' => 'File uploaded successfully',
//                                    'data'    => $finalImage
//                                ], 200);
//            }
//        } catch (Exception$e) {
//            return response([
//                                'status'  => 'server_error',
//                                'message' => $e->getMessage(),
//                            ], 500);
//        }
//    }
}

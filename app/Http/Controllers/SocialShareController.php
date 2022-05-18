<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jorenvh\Share\Share;

class SocialShareController extends Controller
{
    public function index()
    {
        $host =request()->getHost();

//        dd($host);
        $shareButtons = (new \Jorenvh\Share\Share)->page($host, 'Share title')
            ->facebook()
            ->twitter()
        -> getRawLinks();



        return response([
            'status'=>'success',
            'data'=>$shareButtons
        ]);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class LastSeenUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

//    public function __construct()
//    {
//        $this->middleware(['auth:sanctum'], ['only' => ['store']]);
//    }


    public function handle($request, Closure $next)
    {
////        $user_id = request()->user('sanctum')["id"];
//        if ($user_id) {
////            $expireTime = Carbon::now()->addMinute(1); // keep online for 1 min
////            Cache::put('is_online'.Auth::user()->id, true, $expireTime);
//
//            //Last Seen
//            User::where('id',$user_id)->update(['last_seen' => Carbon::now()]);
//        }
        return $next($request);
    }
}

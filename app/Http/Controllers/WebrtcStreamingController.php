<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\StreamAnswer;
use App\Events\StreamOffer;

class WebrtcStreamingController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware(['auth:sanctum'], ['only' => ['index', 'consumer']]);
//    }

    public function index()
    {
        return view('landing.live.streaming', ['type' => 'broadcaster', 'id' => Auth::id()]);
//        return view('landing.live.streaming', ['type' => 'broadcaster', 'id' => auth()->id()]);
    }

    public function consumer(Request $request, $streamId)
    {
        return view('landing.live.streaming', ['type' => 'consumer', 'streamId' => $streamId, 'id' => Auth::id()]);
//        return view('landing.live.streaming', ['type' => 'consumer', 'streamId' => $streamId, 'id' => auth()->id()]);
    }

    public function makeStreamOffer(Request $request)
    {
        $data['broadcaster'] = $request->broadcaster;
        $data['receiver'] = $request->receiver;
        $data['offer'] = $request->offer;

        event(new StreamOffer($data));
    }

    public function makeStreamAnswer(Request $request)
    {
        $data['broadcaster'] = $request->broadcaster;
        $data['answer'] = $request->answer;
        event(new StreamAnswer($data));
    }
}

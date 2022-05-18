<?php

    use Illuminate\Support\Facades\Broadcast;

    /*
    |--------------------------------------------------------------------------
    | Broadcast Channels
    |--------------------------------------------------------------------------
    |
    | Here you may register all the event broadcasting channels that your
    | application supports. The given channel authorization callbacks are
    | used to check if an authenticated user can listen to the channel.
    |
     */

    // Dynamic Presence Channel for Streaming
    Broadcast::channel('streaming-channel.{streamId}', function ($user) {
//        return ['id' => $user->id, 'name' => $user->name];
        return (int) $user-> id === (int) \App\Models\User::find('id') -> user_id;
    });

    // Signaling Offer and Answer Channels
    Broadcast::channel('stream-signal-channel.{userId}', function ($user, $userId) {
        return (int) $user->id === (int) $userId;
    });


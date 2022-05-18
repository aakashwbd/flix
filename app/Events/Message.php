<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $from_user_id;
    public $to_user_id;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($from_user_id, $to_user_id, $message)
    {
        $this->from_user_id = $from_user_id;
        $this->to_user_id   = $to_user_id;
        $this->message      = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        return 'message';
    }
}

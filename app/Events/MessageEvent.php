<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $receiverId;
    public $sender;

    public function __construct($message, $receiverId, User $sender) {
        $this->message = $message;
        $this->receiverId = $receiverId;
        $this->sender = $sender;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('chat.'.$this->receiverId);
    }


}

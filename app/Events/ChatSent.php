<?php

namespace App\Events;

use App\ChatMessage;
use App\Operator;
use App\Product;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
        $this->message->load('user');
        $this->message->load('operator');
        $this->message->load('product');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('product-chat_' . $this->message->user->id . "_" . $this->message->product->id);
        //return new PrivateChannel('product-chat');
    }
}

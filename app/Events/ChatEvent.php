<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent
{
    public string $message;

    public string $broadcastName;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $message, string $broadcastName)
    {
        $this->message = $message;
        $this->broadcastName = $broadcastName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-chat-p2p');
    }


    public function broadcastAs()
    {
        return $this->broadcastName;
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}

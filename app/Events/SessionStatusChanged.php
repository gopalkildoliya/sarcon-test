<?php

namespace App\Events;

use App\Models\EventSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SessionStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventSession;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EventSession $eventSession)
    {
        $this->eventSession = $eventSession;
    }

    public function broadcastAs()
    {
        return 'event.status.changed';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->eventSession->id,
            'audience_can_join' => $this->eventSession->audience_can_join
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('events');
    }
}

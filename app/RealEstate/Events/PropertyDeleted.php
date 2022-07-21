<?php

namespace App\RealEstate\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PropertyDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var mixed
     */
    public $property;

    /**
     * Create a new event instance.
     *
     * @param mixed $property
     * @return void
     */
    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

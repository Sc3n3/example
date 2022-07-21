<?php

namespace App\RealEstate\Events;

use App\RealEstate\Models\Property;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PropertyUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Property
     */
    public $property;

    /**
     * Create a new event instance.
     *
     * @param Property $property
     * @return void
     */
    public function __construct(Property $property)
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

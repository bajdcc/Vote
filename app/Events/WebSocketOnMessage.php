<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WebSocketOnMessage extends Event
{
    use SerializesModels;

    public $event;
    public $data;

    /**
     * Create a new event instance.
     *
     * @param String $event
     * @param mixed $data
     */
    public function __construct($event, $data)
    {
        $this->event = $event;
        $this->data = $data;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    public function __tostring(){
        $array = array(
            'event' => $this->event,
            'data' => $this->data
        );
        return collect($array)->toJson();
    }
}

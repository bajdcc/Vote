<?php

namespace App\Listeners;

use App\Events\WebSocketOnMessage;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

class WebSocketOnMessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WebSocketOnMessage  $event
     * @return void
     */
    public function handle(WebSocketOnMessage $event)
    {

    }

    static public function registerEvent(DispatcherContract $events)
    {
        $events->listen('generic.event', function ($client_data) {
            \Event::fire(new WebSocketOnMessage('generic.event', $client_data));
        });

        $events->listen('app.success', function ($client_data) {
        });

        $events->listen('app.error', function ($client_data) {
        });
    }
}

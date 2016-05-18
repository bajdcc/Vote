<?php

namespace App\Console\Commands;

use App\Listeners\WebSocketEventListener;
use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use BrainSocket\BrainSocketResponse;
use BrainSocket\LaravelEventPublisher;

class StartWebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Websocket Server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Start WebSocket server
        $port = config('websocket.port');
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketEventListener(
                        new BrainSocketResponse(new LaravelEventPublisher())
                    )
                )
            )
            , $port
        );
        $this->info('WebSocket server started on port:'.$port);
        $server->run();
    }
}

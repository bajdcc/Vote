<?php
namespace App\Listeners;

use App\Events\WebSocketOnMessage;
use Ratchet\ConnectionInterface;
use BrainSocket\BrainSocketEventListener;
use BrainSocket\BrainSocketResponseInterface;

class WebSocketEventListener extends BrainSocketEventListener
{
    public function __construct(BrainSocketResponseInterface $response)
    {
        parent::__construct($response);
    }

    public function onOpen(ConnectionInterface $conn)
    {
        parent::onOpen($conn);
        $data = array(
            'id' => $conn->resourceId,
            'count' => count($this->clients)
        );
        $this->broadcast($conn, 'client.connect', $data);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        parent::onMessage($from, $msg);
    }

    public function onClose(ConnectionInterface $conn)
    {
        parent::onClose($conn);
        $data = array(
            'id' => $conn->resourceId,
            'count' => count($this->clients)
        );
        $this->broadcast($conn, 'client.disconnect', $data);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        parent::onError($conn, $e);
    }

    public function broadcast(ConnectionInterface $conn, $event, $data)
    {
        $msg = array(
            'client' => array(
                'event' => $event,
                'data' => $data
            )
        );
        $msg = json_encode($msg);
        $count = count($this->clients);

        echo sprintf('Connection %d broadcast message "%s" to all of %d %s' . "\n"
            ,  $conn->resourceId, $msg, $count, str_plural('connection',  $count));

        foreach ($this->clients as $client) {
            $client->send($this->response->make($msg));
        }
        \Event::fire(new WebSocketOnMessage($event, $data));
    }
}
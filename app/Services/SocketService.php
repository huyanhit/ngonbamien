<?php

namespace App\Services;

use ElephantIO\Client;
use Mockery\Exception;

class SocketService{

    private $connect = true;
    protected Client $client;
    public function send($data): void
    {
        $this->connect();
        $this->client->emit('push-socket', $data);
        $this->disconnect();
    }

    public function connect():void
    {
        try {
            $options = [
                'client' => Client::CLIENT_4X,
                'headers' => [
                    'Authorization' => config('app.socket_key'),
                ],
            ];
            $this->client = Client::create(config('app.socket_domain'), $options)->connect();
        } catch (\Exception $e) {
            $this->connect = false;
        }
    }
    
    public function emit($data): void
    {
        if($this->connect){
            $this->client->emit('push-socket', $data);
        }
    }

    public function disconnect(): void
    {
        if($this->connect){
            $this->client->disconnect();
        }
    }
}

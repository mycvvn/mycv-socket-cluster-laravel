<?php

namespace MyCV\SocketCluster;

use GuzzleHttp\Client;

class SocketCluster
{
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('MYCV_SOCKET_CLUSTER_URL'),
            'headers' => [
                'MyCV-Public-Key' => env('MYCV_SOCKET_CLUSTER_PUBLIC_KEY'),
                'MyCV-Secret-Key' => env('MYCV_SOCKET_CLUSTER_PRIVATE_KEY'),
            ]
        ]);
    }
    
    public function publish($channel, $data)
    {
        $response = $this->client->request('POST', '/publish', [
            'form_params' => [
                'channel' => $channel,
                'data' => \json_encode($data)
            ]
        ]);
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 200 && $statusCode < 300) {
            return json_decode($response->getBody()->getContents());
        }
    }
}
<?php

namespace Jooyeshgar\Moadian;

use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;

class Moadian
{
    protected $username;

    protected $privateKey;

    protected $client;

    public function __construct($username, $privateKey)
    {
        $this->username = $username;
        $this->privateKey = $privateKey;

    }

    public function getFiscalInfo($documentId)
    {
        $response = $this->client->get("fiscal/documents/{$documentId}");

        return json_decode($response->getBody()->getContents());
    }


}
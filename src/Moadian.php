<?php
namespace Jooyeshgar\Moadian;

use GuzzleHttp\Client;
use Jooyeshgar\Moadian\Services\ApiClient;
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
        $this->client = new ApiClient($username, $privateKey);
    }

    public function getServerInfo()
    {
        $response = $this->client->getServerInfo();

        return $response->getData();
    }

    public function getFiscalInfo($fiscalId)
    {
        $response = $this->client->getFiscalInfo();

        return $response->getData();
    }
}
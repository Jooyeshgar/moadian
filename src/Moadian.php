<?php
namespace Jooyeshgar\Moadian;

use GuzzleHttp\Client;
use Jooyeshgar\Moadian\Services\ApiClient;
use Ramsey\Uuid\Uuid;

class Moadian
{
    protected $username;

    protected $privateKey;

    protected ApiClient $client;

    public function __construct($username, $privateKey, $baseUri ='https://tp.tax.gov.ir/')
    {
        $this->username = $username;
        $this->privateKey = $privateKey;
        $this->client = new ApiClient($username, $privateKey, $baseUri);
    }

    public function getToken()
    {
        return $this->client->getToken();
    }

    public function getServerInfo()
    {
        $response = $this->client->getServerInfo();

        return $response;
    }

    public function getFiscalInfo($fiscalId)
    {
        $response = $this->client->getFiscalInfo();

        return $response->getData();
    }
}
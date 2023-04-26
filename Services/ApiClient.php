<?php

namespace Jooyeshgar\Moadian;

use Jooyeshgar\Moadian\Packet;
use GuzzleHttp\Client;
use Jooyeshgar\Moadian\Exceptions\MoadianException;

class ApiClient
{
    private Client $httpClient;
    private $token;

    public function __construct($baseUri = 'https://tp.tax.gov.ir')
    {
        $this->httpClient = new Client([
            'base_uri' => $baseUri,
            'headers' => ['Content-Type' => 'application/json'],
        ]);
    }
    /**
     * Sends a packet to the API server.
     *
     * @param Packet $packet The packet to send.
     * @return mixed The response from the API server.
     */
    public function sendPacket(Packet $packet)
    {
        if($packet->needToken) $packet = $this->addToken($packet);
        if($packet->needSign) $packet = $this->signPacket($packet);
        if($packet->needEncrypt) $packet = $this->encryptPacket($packet);
        
        return $this->httpClient->post($packet->getPath(), [
            'body' => $packet->getContent(),
            'headers' => $packet->getHeaders(),
        ]);
    }

    private function addToken(Packet $packet)
    {
        if(!is_null($this->token)){
            $this->getToken();
        }
        return $packet->setToken($this->token);
    }

    private function getToken()
    {
        $packet = new getTokenPacket();
        $response = $this->sendPacket($packet);
        if($response->token){
            $this->token = $response->token;
            return $this->token; 
        }

        throw new MoadianException('Unable to retrieve Token');
    }


    /**
     * Signs a packet with a digital signature.
     *
     * @param Packet $packet The packet to sign.
     * @return void
     */
    private function signPacket(Packet $packet)
    {
        return $packet;
    }

    /**
     * Encrypts a packet with a symmetric encryption algorithm.
     *
     * @param Packet $packet The packet to encrypt.
     * @return void
     */
    private function encryptPacket(Packet $packet)
    {
        return $packet;
    }

    public function getServerInfo()
    {
        $packet = new serverInfoPacket();
        return $this->sendPacket($packet);
    }

    public function getFiscalInfo()
    {
        $packet = new fiscalInfoPacket();
        return $this->sendPacket($packet);
    }
}
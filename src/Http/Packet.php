<?php

namespace Jooyeshgar\Moadian\Http;

class Packet
{
    // Packet feild
    public string $uid;
    public string $packetType;
    public bool $retry;
    public $data;
    public string $encryptionKeyId = '';
    public string $symmetricKey = '';
    public string $iv = '';
    public string $fiscalId = '';
    public string $dataSignature;

    // Headers feild
    public string $requestTraceId;



    public bool $needToken = false;
    public bool $needSign = false;
    public bool $needEncrypt = false;

    private string $token;

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function getHeaders()
    {
        //
    }

    public function getBody()
    {
        //
    }

    public function getPath()
    {
        //
    }
}
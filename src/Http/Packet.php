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

    public string $path;

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
        $headers = [
            'requestTraceId' => $this->requestTraceId,
            'timestamp' => time()
        ];

        if ($this->needToken) {
            $headers['authorization'] = $this->token;
        }

        return json_encode($headers);
    }

    public function getBody()
    {
        //
    }
}
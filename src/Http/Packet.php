<?php

namespace Jooyeshgar\Moadian\Http;

use Ramsey\Uuid\Nonstandard\Uuid;

class Packet
{
    // Packet felids
    // public ?string $uid = null;
    public string $packetType = "GET_SERVER_INFORMATION";
    public bool $retry = false;
    public $data;
    public string $encryptionKeyId = '';
    public string $symmetricKey = '';
    public string $iv = '';
    public string $fiscalId = '';
    public ?string $dataSignature = null;

    // Headers felids
    public string $requestTraceId;

    public string $path = 'req/api/self-tsp/sync/GET_SERVER_INFORMATION';

    public bool $needToken = false;
    public bool $needSign = false;
    public bool $needEncrypt = false;

    private string $token;

    public string $signature = "";

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function getHeaders()
    {
        $headers = [
            'requestTraceId' => $this->getTraceId(),
            'timestamp' => (string)(int) floor(microtime(true) * 1000)
        ];

        if ($this->needToken) {
            $headers['authorization'] = $this->token;
        }

        return $headers;
    }


    public function getPacket()
    {
        $data = [
                "uid" => (string) Uuid::uuid4(),
                "packetType" => $this->packetType,
                "retry" => $this->retry,
                "data" => $this->data,
                "encryptionKeyId" => $this->encryptionKeyId,
                "symmetricKey" => $this->symmetricKey,
                "iv" => $this->iv,
                "fiscalId" => $this->fiscalId,
                "dataSignature" => $this->dataSignature
        ];
        return $data;
    }

    public function getBody()
    {
       
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        $data = [
            "packet" => $this->getPacket(),
            "signature" => $this->signature,
        ];
        
        return $data;
    }

    protected function getTraceId($new = false)
    {
        if ($new) {
            return $this->requestTraceId = Uuid::uuid4()->toString();
        }

        return $this->requestTraceId ??= Uuid::uuid4()->toString();
    }
}
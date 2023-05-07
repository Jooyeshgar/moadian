<?php

namespace Jooyeshgar\Moadian\Http;

use Ramsey\Uuid\Nonstandard\Uuid;

class Packet
{
    // Packet fields
    public string $uid = '';
    public string $packetType = "GET_SERVER_INFORMATION";
    public bool $retry = false;
    public $data;
    public string $encryptionKeyId = '';
    public string $symmetricKey = '';
    public string $iv = '';
    public string $fiscalId = '';
    public string $dataSignature = '';

    public string $path        = 'req/api/self-tsp/sync/GET_SERVER_INFORMATION';
    public bool   $needToken   = false;
    public bool   $needEncrypt = false;
   

    public function __construct() 
    {
        $this->uid = Uuid::uuid4()->toString();
    }

    public function toArray()
    {
        return [
            "uid" => $this->uid,
            "packetType" => $this->packetType,
            "retry" => $this->retry,
            "data" => $this->data,
            "encryptionKeyId" => $this->encryptionKeyId,
            "symmetricKey" => $this->symmetricKey,
            "iv" => $this->iv,
            "fiscalId" => $this->fiscalId,
            "dataSignature" => $this->dataSignature
        ];
    }
}
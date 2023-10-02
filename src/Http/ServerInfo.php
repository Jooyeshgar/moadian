<?php

namespace Jooyeshgar\Moadian\Http;

use Jooyeshgar\Moadian\Services\EncryptionService;
use Jooyeshgar\Moadian\Services\SignatureService;
use Jooyeshgar\Moadian\Traits\HasToken;

class ServerInfo extends Request
{
    use HasToken;

    public function __construct()
    {
        parent::__construct();

        $this->path = 'server-information';
    }

    public function prepare(SignatureService $signer, EncryptionService $encryptor)
    {
        $this->addToken($signer);
    }
}
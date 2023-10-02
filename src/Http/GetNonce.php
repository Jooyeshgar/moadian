<?php

namespace Jooyeshgar\Moadian\Http;

use Jooyeshgar\Moadian\Services\SignatureService;
use Jooyeshgar\Moadian\Services\EncryptionService;

class GetNonce extends Request
{
    /**
     * @param int $validity Optional. Validity period of string in seconds.
     */
    public function __construct(int $validity = 30)
    {
        parent::__construct();

        $this->path = 'nonce';
        $this->params['timeToLive'] = $validity;
    }

    public function prepare(SignatureService $signer, EncryptionService $encryptor) {}
}
<?php

namespace Jooyeshgar\Moadian\Http;

use Jooyeshgar\Moadian\Services\EncryptionService;
use Jooyeshgar\Moadian\Services\SignatureService;
use Jooyeshgar\Moadian\Traits\HasToken;

class EconomicCodeInformation extends Request
{
    use HasToken;

    public function __construct(string $taxId)
    {
        parent::__construct();

        $this->path = 'taxpayer';
        $this->params['economicCode'] = $taxId;
    }

    public function prepare(SignatureService $signer, EncryptionService $encryptor)
    {
        $this->addToken($signer);
    }
}
<?php

namespace Jooyeshgar\Moadian\Http;

use Jooyeshgar\Moadian\Services\EncryptionService;
use Jooyeshgar\Moadian\Services\SignatureService;
use Jooyeshgar\Moadian\Traits\HasToken;

class InquiryInvoiceStatus extends Request
{
    use HasToken;

    public function __construct(string $taxIds) {
        parent::__construct();

        $this->path = 'inquiry-invoice-status';
        $this->params['taxIds'] = $taxIds;
    }

    public function prepare(SignatureService $signer, EncryptionService $encryptor)
    {
        $this->addToken($signer);
    }
}

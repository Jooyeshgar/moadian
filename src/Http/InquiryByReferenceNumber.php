<?php

namespace Jooyeshgar\Moadian\Http;

use Jooyeshgar\Moadian\Services\EncryptionService;
use Jooyeshgar\Moadian\Services\SignatureService;
use Jooyeshgar\Moadian\Traits\HasToken;

class InquiryByReferenceNumber extends Request
{
    use HasToken;

    public function __construct(string $referenceId, string $start = '', string $end = '')
    {
        parent::__construct();

        $this->path = 'inquiry-by-reference-id';
        $this->params['referenceIds'] = $referenceId;

        if (!empty($start)) {
            $this->params['start'] = $start;
        }
        if (!empty($end)) {
            $this->params['end'] = $end;
        }
    }

    public function prepare(SignatureService $signer, EncryptionService $encryptor)
    {
        $this->addToken($signer);
    }
}
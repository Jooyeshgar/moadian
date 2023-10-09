<?php

namespace Jooyeshgar\Moadian\Http;

use Jooyeshgar\Moadian\Services\EncryptionService;
use Jooyeshgar\Moadian\Services\SignatureService;
use Jooyeshgar\Moadian\Traits\HasToken;

class InquiryByUid extends Request
{
    use HasToken;

    public function __construct(string $uid, string $start = '', string $end = '') {
        parent::__construct();

        $this->path = 'inquiry-by-uid';
        $this->params['uidList'] = $uid;
        $this->params['fiscalId'] = config('moadian.username');

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

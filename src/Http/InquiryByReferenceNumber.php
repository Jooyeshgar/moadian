<?php

namespace Jooyeshgar\Moadian\Http;

class InquiryByReferenceNumber extends Packet
{
    public function __construct(array $refNums, string $username)
    {
        parent::__construct();

        $this->path       = 'req/api/self-tsp/sync/INQUIRY_BY_REFERENCE_NUMBER';
        $this->packetType = 'INQUIRY_BY_REFERENCE_NUMBER';
        $this->fiscalId   = $username;
        $this->needToken  = true;

        $this->data = [
            'referenceNumber' => $refNums,
        ];
    }
}
<?php

namespace Jooyeshgar\Moadian\Http;

class InquiryByUid extends Packet
{
    public function __construct() {
        
        parent::__construct();

        $this->path       = 'req/api/self-tsp/sync/INQUIRY_BY_UID';
        $this->packetType = 'INQUIRY_BY_UID';
        $this->needToken  = true;
    }
}
<?php

namespace Jooyeshgar\Moadian\Http;

class invoicePacket extends Packet
{
    public function __construct() {
        
        parent::__construct();

        $this->path       = 'req/api/self-tsp/async/normal-enqueue';
        $this->packetType = 'INVOICE.V01';
        $this->needToken  = true;
        $this->needSign  = true;
    }
}
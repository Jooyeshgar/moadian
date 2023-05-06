<?php

namespace Jooyeshgar\Moadian\Http;

class invoicePacket extends Packet
{
    public function __construct(string $username) {
        
        parent::__construct();

        $this->path       = 'req/api/self-tsp/async/normal-enqueue';
        $this->packetType = 'INVOICE.V01';
        $this->fiscalId = $username;
        $this->needToken  = true;
        $this->needEncrypt  = true;
    }

    public function toArray()
    {
        $data = [
            "packets" => [$this->getPacket()],
            "signature" => $this->signature,
        ];
        return $data;
    }
}
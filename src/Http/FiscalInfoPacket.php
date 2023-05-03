<?php

namespace Jooyeshgar\Moadian\Http;

class FiscalInfoPacket extends Packet
{
    public function __construct(string $username) {
        parent::__construct();

        $this->path = 'req/api/self-tsp/sync/GET_FISCAL_INFORMATION';
        $this->packetType = 'GET_FISCAL_INFORMATION';
        $this->fiscalId = $username;
        $this->needToken = true;
    }
}
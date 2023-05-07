<?php

namespace Jooyeshgar\Moadian\Http;

class EconomicCodeInformation extends Packet
{
    public function __construct(string $taxId)
    {
        parent::__construct();

        $this->path       = 'req/api/self-tsp/sync/GET_ECONOMIC_CODE_INFORMATION';
        $this->packetType = 'GET_ECONOMIC_CODE_INFORMATION';
        
        $this->data = [
            'economicCode' => $taxId,
        ];
    }
}
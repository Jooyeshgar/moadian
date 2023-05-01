<?php

namespace Jooyeshgar\Moadian\Http;

use Ramsey\Uuid\Uuid;

class GetTokenPacket extends Packet
{
    //
    public function __construct() {
        $this->path       = 'req/api/self-tsp/sync/GET_TOKEN';
        $this->packetType = 'GET_TOKEN';
        $this->retry      = false;
        $this->needToken  = false;
        $this->needEncrypt= false;

        parent::__construct();
    }
}
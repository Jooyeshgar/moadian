<?php

namespace Jooyeshgar\Moadian\Http;

use Jooyeshgar\Moadian\Invoice;

class invoicePacket extends Packet
{
    public function __construct(string $username, Invoice $invoice) {

        parent::__construct();

        $this->path        = 'req/api/self-tsp/async/normal-enqueue';
        $this->packetType  = 'INVOICE.V01';
        $this->fiscalId    = $username;
        $this->needToken   = true;
        $this->needEncrypt = true;
        $this->data        = $invoice->toArray();
        $this->retry       = $invoice->retry;

        unset($this->data['header']['clientId']);
    }
}
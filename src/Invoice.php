<?php

namespace Jooyeshgar\Moadian;

class Invoice
{
    private InvoiceHeader $header;
    private array $body = [];
    private array $payments = [];

    public $retry = false;
    
    public function __construct(InvoiceHeader $header)
    {
        $this->header = $header;
    }

    public function addItem(InvoiceItem $item)
    {
        $this->body[] = $item;
    }

    public function addPayment(Payment $payment)
    {
        $this->payments[] = $payment;
    }

    public function toArray()
    {
        return [
            'header'  => $this->header->toArray(),

            'body'    => array_map(function ($item){
                return $item->toArray();
            }, $this->body),

            'payments' => array_map(function ($item){
                return $item->toArray();
            }, $this->payments),

            'extension' => null,
        ];
    }
}
<?php

namespace Jooyeshgar\Moadian;

class Invoice
{
    private InvoiceHeader $header;
    private array $body = [];
    private array $payment = [];

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
        $this->payment[] = $payment;
    }

    public function toArray()
    {
        return [
            'header'  => $this->header->toArray(),

            'body'    => array_map(function ($item){ 
                return $item->toArray();
            }, $this->body),

            'payment' => array_map(function ($item){
                return $item->toArray();
            }, $this->payment),

            'extension' => null,
        ];
    }
}
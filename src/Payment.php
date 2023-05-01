<?php

namespace Jooyeshgar\Moadian;

class Payment
{
    
    /**
     * Iin number
     */
    public ?string $iinn;

    /**
     * acceptor number
     */
    public ?string $acn;

    /**
     * terminal number
     */
    public ?string $trmn;

    /**
     * tracking number
     */
    public ?string $trn;

    /**
     * payer card number
     */
    public ?string $pcn;

    /**
     * payer id
     */
    public ?string $pid;

    /**
     * payment DateTime
     */
    public ?int $pdt;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
<?php

namespace Jooyeshgar\Moadian;

use Jooyeshgar\Moadian\Traits\SetFromArray;

class Payment
{
    use SetFromArray;

    /**
     * Property that MUST exclude in setData
     */
    private array $excludedMap = [];

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
     * payment method
     */
    public ?int $pmt;

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

    /**
     * payment value
     */
    public ?float $pv;

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * set data from array
     */
    public function setData(array $data): void
    {
        $vars = get_class_vars(get_class($this));
        $excludedMap = [];
        foreach ($data as $key => $value) {
            if (isset($vars[$key]) && !in_array($key, $excludedMap)) {
                $this->$key = $value;
            }
        }
    }
}
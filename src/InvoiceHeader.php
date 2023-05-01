<?php

namespace Jooyeshgar\Moadian;

class InvoiceHeader
{
    /**
     * unique tax ID (should be generated using InvoiceIdService)
     */
    public string $taxid;

    /**
     * invoice timestamp (milliseconds from epoch)
     */
    public int $indatim;

    /**
     * invoice creation timestamp (milliseconds from epoch)
     */
    public int $indati2m;

    /**
     * invoice type
     */
    public int $inty;

    /**
     * internal invoice number
     */
    public ?string $inno = null;

    /**
     * invoice reference tax ID
     */
    public ?string $irtaxid;

    /**
     * invoice pattern
     */
    public int $inp;

    /**
     * invoice subject
     */
    public int $ins;

    /**
     * seller tax identification number
     */
    public string $tins;

    /**
     * type of buyer
     */
    public ?int $tob;

    /**
     * buyer ID
     */
    public ?string $bid;

    /**
     * buyer tax identification number
     */
    public ?string $tinb;

    /**
     * seller branch code
     */
    public ?string $sbc;

    /**
     * buyer postal code
     */
    public ?string $bpc;

    /**
     * buyer branch code
     */
    public ?string $bbc;

    /**
     * flight type
     */
    public ?int $ft;

    /**
     * buyer passport number
     */
    public ?string $bpn;

    /**
     * seller customs licence number
     */
    public ?int $scln;

    /**
     * seller customs code
     */
    public ?string $scc;

    /**
     * contract registration number
     */
    public ?int $crn;

    /**
     * billing ID
     */
    public ?string $billid;

    /**
     * total pre discount
     */
    public int $tprdis;

    /**
     * total discount
     */
    public int $tdis;

    /**
     * total after discount
     */
    public int $tadis;

    /**
     * total VAT amount
     */
    public int $tvam;

    /**
     * total other duty amount
     */
    public int $todam;

    /**
     * total bill
     */
    public int $tbill;

    /**
     * settlement type
     */
    public ?int $setm;

    /**
     * cash payment
     */
    public ?int $cap;

    /**
     * installment payment
     */
    public ?int $insp;

    /**
     * total VAT of payment
     */
    public ?string $tvop;

    /**
     * tax17
     */
    public int $tax17;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
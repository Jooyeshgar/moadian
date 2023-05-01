<?php

namespace Jooyeshgar\Moadian;

class InvoiceItem
{
     /**
     * service stuff ID
     */
    public ?string $sstid;

    /**
     * service stuff title
     */
    public string $sstt;

    /**
     * amount
     */
    public int $am;

    /**
     * measurement unit
     */
    public string $mu;

    /**
     * fee (pure price per item)
     */
    public int $fee;

    /**
     * fee in foreign currency
     */
    public ?float $cfee;

    /**
     * currency type
     */
    public ?string $cut;

    /**
     * exchange rate
     */
    public ?int $exr;

    /**
     * pre discount
     */
    public int $prdis;

    /**
     * discount
     */
    public int $dis;

    /**
     * after discount
     */
    public int $adis;

    /**
     * VAT rate
     */
    public int $vra;

    /**
     * VAT amount
     */
    public int $vam;

    /**
     * over duty title
     */
    public ?string $odt;

    /**
     * over duty rate
     */
    public ?float $odr;

    /**
     * over duty amount
     */
    public ?int $odam;

    /**
     * other legal title
     */
    public ?string $olt;

    /**
     * other legal rate
     */
    public ?float $olr;

    /**
     * other legal amount
     */
    public ?int $olam;

    /**
     * construction fee
     */
    public ?int $consfee;

    /**
     * seller profit
     */
    public ?int $spro;

    /**
     * broker salary
     */
    public ?int $bros;

    /**
     * total construction profit broker salary
     */
    public ?int $tcpbs;

    /**
     * cash share of payment
     */
    public ?int $cop;

    /**
     * vat of payment
     */
    public ?string $vop;

    /**
     * buyer register number
     */
    public ?string $bsrn;

    /**
     * total service stuff amount
     */
    public int $tsstam;

    // public function toArray(): array
    // {
    //     return [
    //         'sstid' => $this->sstid,
    //         'sstt' => $this->sstt,
    //         'am' => $this->am,
    //         'mu' => $this->mu,
    //         'fee' => $this->fee,
    //         'cfee' => $this->cfee,
    //         'cut' => $this->cut,
    //         'exr' => $this->exr,
    //         'prdis' => $this->prdis,
    //         'dis' => $this->dis,
    //         'adis' => $this->adis,
    //         'vra' => $this->vra,
    //         'vam' => $this->vam,
    //         'odt' => $this->odt,
    //         'odr' => $this->odr,
    //         'odam' => $this->odam,
    //         'olt' => $this->olt,
    //         'olr' => $this->olr,
    //         'olam' => $this->olam,
    //         'consfee' => $this->consfee,
    //         'spro' => $this->spro,
    //         'bros' => $this->bros,
    //         'tcpbs' => $this->tcpbs,
    //         'cop' => $this->cop,
    //         'vop' => $this->vop,
    //         'bsrn' => $this->bsrn,
    //         'tsstam' => $this->tsstam,
    //     ];
    // }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
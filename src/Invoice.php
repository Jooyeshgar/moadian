<?php

namespace Jooyeshgar\Moadian;

class Invoice
{
    /**
     * service stuff ID
     */
    private ?string $sstid;

    /**
     * service stuff title
     */
    private string $sstt;

    /**
     * amount
     */
    private int $am;

    /**
     * measurement unit
     */
    private string $mu;

    /**
     * fee (pure price per item)
     */
    private int $fee;

    /**
     * fee in foreign currency
     */
    private ?float $cfee;

    /**
     * currency type
     */
    private ?string $cut;

    /**
     * exchange rate
     */
    private ?int $exr;

    /**
     * pre discount
     */
    private int $prdis;

    /**
     * discount
     */
    private int $dis;

    /**
     * after discount
     */
    private int $adis;

    /**
     * VAT rate
     */
    private int $vra;

    /**
     * VAT amount
     */
    private int $vam;

    /**
     * over duty title
     */
    private ?string $odt;

    /**
     * over duty rate
     */
    private ?float $odr;

    /**
     * over duty amount
     */
    private ?int $odam;

    /**
     * other legal title
     */
    private ?string $olt;

    /**
     * other legal rate
     */
    private ?float $olr;

    /**
     * other legal amount
     */
    private ?int $olam;

    /**
     * construction fee
     */
    private ?int $consfee;

    /**
     * seller profit
     */
    private ?int $spro;

    /**
     * broker salary
     */
    private ?int $bros;

    /**
     * total construction profit broker salary
     */
    private ?int $tcpbs;

    /**
     * cash share of payment
     */
    private ?int $cop;

    /**
     * vat of payment
     */
    private ?string $vop;

    /**
     * buyer register number
     */
    private ?string $bsrn;

    /**
     * total service stuff amount
     */
    private int $tsstam;


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
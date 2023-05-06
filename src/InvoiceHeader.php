<?php

namespace Jooyeshgar\Moadian;

use DateTime;
use Jooyeshgar\Moadian\Services\VerhoeffService;

class InvoiceHeader
{
    /**
     * MOADIAN_USERNAME
     */
    public string $clientId;

    /**
     * unique tax ID (should be set by setTaxID )
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

    public function __construct(string $username = null) {
        $this->clientId = $username;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function setTaxID(DateTime $date, int $internalInvoiceId)
    {
        $daysPastEpoch = $this->getDaysPastEpoch($date);
        $daysPastEpochPadded = str_pad($daysPastEpoch, 6, '0', STR_PAD_LEFT);
        $hexDaysPastEpochPadded = str_pad(dechex($daysPastEpoch), 5, '0', STR_PAD_LEFT);

        $numericClientId = $this->clientIdToNumber($this->clientId);

        $internalInvoiceIdPadded = str_pad($internalInvoiceId, 12, '0', STR_PAD_LEFT);
        $hexInternalInvoiceIdPadded = str_pad(dechex($internalInvoiceId), 10, '0', STR_PAD_LEFT);

        $decimalInvoiceId = $numericClientId . $daysPastEpochPadded . $internalInvoiceIdPadded;

        $checksum = VerhoeffService::checkSum($decimalInvoiceId);

        $this->taxid = strtoupper($this->clientId . $hexDaysPastEpochPadded . $hexInternalInvoiceIdPadded . $checksum);
    }

    private function getDaysPastEpoch(DateTime $date): int
    {
        return (int)($date->getTimestamp() / (3600 * 24));
    }

    private function clientIdToNumber(string $clientId): string
    {
        define('CHARACTER_TO_NUMBER_CODING', [
            'A' => 65, 'B' => 66, 'C' => 67, 'D' => 68, 'E' => 69, 'F' => 70, 'G' => 71, 'H' => 72, 'I' => 73,
            'J' => 74, 'K' => 75, 'L' => 76, 'M' => 77, 'N' => 78, 'O' => 79, 'P' => 80, 'Q' => 81, 'R' => 82,
            'S' => 83, 'T' => 84, 'U' => 85, 'V' => 86, 'W' => 87, 'X' => 88, 'Y' => 89, 'Z' => 90,
        ]);
    
        $result = '';
        foreach (str_split($clientId) as $char) {
            if (is_numeric($char)) {
                $result .= $char;
            } else {
                $result .= CHARACTER_TO_NUMBER_CODING[$char];
            }
        }
    
        return $result;
    }
}

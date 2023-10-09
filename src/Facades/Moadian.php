<?php

namespace Jooyeshgar\Moadian\Facades;

/**
 * @method static string getNonce(int $validity = 30) 
 * @method static Jooyeshgar\Moadian\Http\Response getServerInfo()
 * @method static Jooyeshgar\Moadian\Http\Response getFiscalInfo()
 * @method static Jooyeshgar\Moadian\Http\Response inquiryByUid(string $uid, string $start = '', string $end = '')
 * @method static Jooyeshgar\Moadian\Http\Response inquiryByReferenceNumbers(string $referenceId, string $start = '', string $end = '')
 * @method static Jooyeshgar\Moadian\Http\Response getEconomicCodeInformation(string $taxID)
 * @method static Jooyeshgar\Moadian\Http\Response sendInvoice(Invoice $invoice)
 * 
 * @see \Jooyeshgar\Moadian\Moadian
 */

use Illuminate\Support\Facades\Facade;

class Moadian extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Jooyeshgar\Moadian\Moadian';
    }
}

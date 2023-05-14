# Laravel Moadian API Driver

This Laravel package provides a convenient way to interact with the API of the "Moadian system" (سامانه مودیان) offered by intamedia.ir. With this package, you can easily make requests to the Moadian API and handle the responses in your Laravel application.

## Requirements

This package requires Laravel 8 or higher. It has been tested with Laravel 8 and PHP 7.4, as well as with Laravel 10 and PHP 8.1.

## Installation

To install this package, simply run the following command:
```bash
composer require jooyeshgar/moadian
```
## Usage

To use this package, you will need to obtain a username and private key from intamedia.ir. Once you have your credentials, you can configure the package in your Laravel application's `.env` file:

```
MOADIAN_USERNAME=your-username-here
MOADIAN_PRIVATE_KEY_PATH=/path/to/private.key
```
The default location to store the private key is:
storage_path('app/keys/private.pem');

You can then use the `Moadian` facade to interact with the Moadian API. Here are some examples:

```php
use Jooyeshgar\Moadian\Facades\Moadian;

// Get server info
$info = Moadian::getServerInfo();

// Get token
$info = Moadian::getToken();

// Get fiscal info
$fiscalInfo = Moadian::getFiscalInfo();

// Get economic code information
$info = Moadian::getEconomicCodeInformation('10840096498');

// Inquiry by reference numbers
$info = Moadian::inquiryByReferenceNumbers(["a45aa663-6888-4025-a89d-86fc789672a0"]);
```

### Send Invoice

To send an invoice to Moadian, you can use the sendInvoice() method provided by the plugin. Here's an example of how to use it:

```php
use Jooyeshgar\Moadian\Invoice as MoadianInvoice;
use Jooyeshgar\Moadian\InvoiceHeader;
use Jooyeshgar\Moadian\InvoiceItem;
use Jooyeshgar\Moadian\Payment;

public function sendInvoice($invoiceId = '') {
    $invoiceId = intval($invoiceId);
    $invoice = Invoice::find($invoiceId);

    if (!$invoice) {
        throw new Exception('Invoice not found');
    }

    $timestamp = Carbon::parse($invoice->date)->timestamp * 1000;

    $Header = new InvoiceHeader(env('MOADIAN_USERNAME'));
    $Header->setTaxID(Carbon::parse($invoice->date), $invoice->number);
    $Header->indati2m = $timestamp;
    $Header->indatim = $timestamp;
    $Header->inty = 1; //invoice type
    $Header->inno = $invoiceId;
    $Header->irtaxid = null; // invoice reference tax ID
    $Header->inp = $invoice->inp; //invoice pattern
    $Header->ins = 1;
    $Header->tins = env('TAXID');
    $Header->tob = 2;
    $Header->bid = $invoice->nationalnum;
    $Header->tinb = $invoice->nationalnum;
    $Header->bpc = $invoice->postal;

    $amount   = $invoice->items->sum('amount');
    $discount = $invoice->items->sum('discount');
    $vat      = $invoice->items->sum('vat');
    $Header->tprdis = $amount;
    $Header->tdis = $discount;
    $Header->tadis = $amount - $discount;
    $Header->tvam = $vat;
    $Header->todam = 0;
    $Header->tbill = $amount - $discount + $vat;
    $Header->setm = $invoice->setm;
    $Header->cap = $amount - $discount + $vat;

    $moadianInvoice = new MoadianInvoice($Header);

    foreach ($invoice->items as $item) {
        $Body = new InvoiceItem();
        $Body->sstid = $item->seals->sstid;
        $Body->sstt = $item->desc;
        $Body->am = '1';
        $Body->mu = 1627;
        $Body->fee = $item->amount;
        $Body->prdis = $item->amount;
        $Body->dis = $item->discount;
        $Body->adis = $item->amount - $item->discount;
        $Body->vra = 9;
        $Body->vam = $item->vat; // or directly calculate here like floor($Body->adis * $Body->vra / 100)
        $Body->tsstam = $item->amount - $item->discount + $item->vat;
        $moadianInvoice->addItem($Body);
    }

    foreach ($invoice->cashes as $cashe) {
        if ($cashe->active == 1) {
            $Payment = new Payment();
            $Payment->trn = $cashe->code;
            $Payment->pdt = Carbon::parse($cashe->date)->timestamp * 1000;
            $moadianInvoice->addPayment($Payment);
        }
    }

    if($invoice->referenceNumber) {
        $moadianInvoice->retry = true;
    }

    $info = Moadian::sendInvoice($moadianInvoice);
    $info = $info->getBody();
    $info = $info[0];

    $invoice->taxID           = $Header->taxid;
    $invoice->uid             = $info['uid'] ?? '';
    $invoice->referenceNumber = $info['referenceNumber'] ?? '';
    $invoice->errorCode       = $info['errorCode'] ?? '';
    $invoice->errorDetail     = $info['errorDetail'] ?? '';
    $invoice->taxResult       = 'send';

    $invoice->save();
}
```

Note that you need to have a valid Moadian account and credentials to use this plugin.


## Contributing

If you find a bug or would like to contribute to this package, please feel free to [submit an issue](https://github.com/Jooyeshgar/moadian/issues) or [create a pull request](https://github.com/Jooyeshgar/moadian/pulls).

## License

This package is open source software licensed under the [GPL-3.0 license](https://opensource.org/licenses/GPL-3.0).
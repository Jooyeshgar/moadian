<?php

namespace Jooyeshgar\Moadian\Tests\Feature;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Jooyeshgar\Moadian\Moadian;
use Jooyeshgar\Moadian\MoadianServiceProvider;
use Jooyeshgar\Moadian\Tests\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;
use Illuminate\Contracts\Foundation\Application;
use Jooyeshgar\Moadian\Invoice;
use Jooyeshgar\Moadian\InvoiceHeader;
use Jooyeshgar\Moadian\InvoiceItem;
use Jooyeshgar\Moadian\Payment;

class MoadianTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            MoadianServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Moadian' => Moadian::class,
        ];
    }

    public function testGetServerInformation()
    {
        $key = file_get_contents(__DIR__.'/private.pem');
        $moadian = new Moadian('A11xxx', $key, 'https://Sandboxrc.tax.gov.ir/');
    
        $serverInfo = $moadian->getServerInfo();
    
        // Check if the response was successful
        $this->assertTrue($serverInfo->isSuccessful());
    
        $data = $serverInfo->getBody();
    
        // Check if the "publicKeys" field exists in the response
        $this->assertArrayHasKey('publicKeys', $data);
    
        // Check if the first "publicKeys" item has the expected "id" value
        $this->assertEquals($data['publicKeys'][0]['id'], '6a2bcd88-a871-4245-a393-2843eafe6e02');
    }

    public function testGetToken()
    {
        $key = file_get_contents(__DIR__.'/private.pem');
        $moadian = new Moadian('A11xxx', $key);

        $res = $moadian->getToken();

        $this->assertIsString($res);
    }

    public function testInquiryByUid()
    {
        $key = file_get_contents(__DIR__ . '/private.pem');
        $moadian = new Moadian('A11xxx', $key);

        $res = $moadian->inquiryByUid([
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString()
        ]);

        $this->assertEquals('NOT_FOUND', $res->getBody()[0]['status']);
        $this->assertEquals('NOT_FOUND', $res->getBody()[1]['status']);
    }

    public function testInquiryByReferenceNumber()
    {
        $key = file_get_contents(__DIR__ . '/private.pem');
        $moadian = new Moadian('A11xxx', $key);

        $res = $moadian->inquiryByReferenceNumbers([
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString()
        ]);

        $this->assertEquals('NOT_FOUND', $res->getBody()[0]['status']);
        $this->assertEquals('NOT_FOUND', $res->getBody()[0]['status']);
    }

    public function testGetFiscalInformation()
    {
        $key = file_get_contents(__DIR__ . '/private.pem');
        $moadian = new Moadian('A11xxx', $key);

        $res = $moadian->getFiscalInfo();

        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('economicCode', $res->getBody());
    }
}
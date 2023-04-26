<?php

namespace Jooyeshgar\Moadian\Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Jooyeshgar\Moadian\Facades\Moadian;
use Jooyeshgar\Moadian\MoadianServiceProvider;
use Jooyeshgar\Moadian\Tests\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;

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

    public function testGetFiscalInfo()
    {
        $documentId = Uuid::uuid4();
        $responseBody = json_encode(['id' => $documentId]);

        $mockedResponse = Mockery::mock(Response::class);
        $mockedResponse->shouldReceive('getBody->getContents')->andReturn($responseBody);

        $mockedClient = Mockery::mock(Client::class);
        $mockedClient->shouldReceive('get')->with("fiscal/documents/{$documentId}")->andReturn($mockedResponse);

        $this->app->instance(Client::class, $mockedClient);

        $fiscalInfo = Moadian::getFiscalInfo($documentId);

        $this->assertEquals($documentId, $fiscalInfo->id);
    }
}
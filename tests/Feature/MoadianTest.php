<?php

namespace Jooyeshgar\Moadian\Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Jooyeshgar\Moadian\Moadian;
use Jooyeshgar\Moadian\MoadianServiceProvider;
use Jooyeshgar\Moadian\Tests\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;
use Illuminate\Contracts\Foundation\Application;

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
        var_dump(getenv('MOADIAN_USERNAME'));
        $moadian = new Moadian(getenv('MOADIAN_USERNAME'), '');
        $fiscalInfo = $moadian->getServerInfo();
var_dump($fiscalInfo);
        $this->assertEquals($documentId, $fiscalInfo->id);
    }

    // public function testGetServerInformation()
    // {
    //     // Define the expected request and response data
    //     $requestData = [
    //         'time' => 1,
    //         'packet' => [
    //             'uid' => null,
    //             'packetType' => 'GET_SERVER_INFORMATION',
    //             'retry' => false,
    //             'data' => null,
    //             'encryptionKeyId' => '',
    //             'symmetricKey' => '',
    //             'iv' => '',
    //             'fiscalId' => '',
    //             'dataSignature' => '',
    //         ],
    //     ];

    //     $responseData = [
    //         'signature' => null,
    //         'signatureKeyId' => null,
    //         'timestamp' => 1655184692934,
    //         'result' => [
    //             'uid' => null,
    //             'packetType' => 'SERVER_INFORMATION',
    //             'data' => [
    //                 'serverTime' => 1655184692934,
    //                 'publicKeys' => [
    //                     [
    //                         'key' => 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAxdzREOEfk3vBQogDPGTMqdDQ7t0oDhuKMZkA+Wm1lhzjjhAGfSUOuDvOKRoUEQwP8oUcXRmYzcvCUgcfoRT5iz7HbovqH+bIeJwT4rmLmFcbfPke+E3DLUxOtIZifEXrKXWgSVPkRnhMgym6UiAtnzwA1rmKstJoWpk9Nv34CYgTk8DKQN5jQJqb9L/Ng0zOEEtI3zA424tsd9zv/kP4/SaSnbbnj0evqsZ29X6aBypvnTnwH9t3gbWM4I9eAVQhPYClawHTqvdaz/O/feqfm06QBFnCgL+CBdjLs30xQSLsPICjnlV1jMzoTZnAabWP6FRzzj6C2sxw9a/WwlXrKn3gldZ7Ctv6Jso72cEeCeUI1tzHMDJPU3Qy12RQzaXujpMhCz1DVa47RvqiumpTNyK9HfFIdhgoupFkxT14XLDl65S55MF6HuQvo/RHSbBJ93FQ+2/x/Q2MNGB3BXOjNwM2pj3ojbDv3pj9CHzvaYQUYM1yOcFmIJqJ72uvVf9Jx9iTObaNNF6pl52ADmh85GTAH1hz+4pR/E9IAXUIl/YiUneYu0G4tiDY4ZXykYNknNfhSgxmn/gPHT+7kL31nyxgjiEEhK0B0vagWvdRCNJSNGWpLtlq4FlCWTAnPI5ctiFgq925e+sySjNaORCoHraBXNEwyiHT2hu5ZipIW2cCAwEAAQ==',
    //                         'id' => '6a2bcd88-a871-4245-a393-2843eafe6e02',
    //                         'algorithm' => 'RSA',
    //                         'purpose' => 1,
    //                     ],
    //                 ],
    //             ],
    //             'encryptionKeyId' => null,
    //             'symmetricKey' => null,
    //             'iv' => null,
    //         ],
    //     ];

    //     // Create a mock object of the HTTP client
    //     $mockedClient = Mockery::mock(Client::class);

    //     // Define the expected endpoint URL and response data
    //     $endpointUrl = 'https://tp.tax.gov.ir/req/api/tsp/sync/GET_SERVER_INFORMATION';

    //     $mockedResponse = Mockery::mock(Response::class);
    //     $mockedResponse->shouldReceive('getBody->getContents')->andReturn(json_encode($responseData));

    //     // Set up the mock client to return the mock response when the endpoint URL is called with the expected request data
    //     $mockedClient->shouldReceive('post')->once()->with($endpointUrl, [
    //         'headers' => [
    //             'requestTraceId' => '1654938179880',
    //             'timestamp' => '1654938179880',
    //             'Content-Type' => 'application/json',
    //         ],
    //         'json' => $requestData    ])->andReturn($mockedResponse);


    //     $this->app->instance(Client::class, $mockedClient);

    //     $fiscalInfo = Moadian::getServerInfo();

    //     $this->assertEquals($responseData, $fiscalInfo);

    // }
}
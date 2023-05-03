<?php

namespace Jooyeshgar\Moadian\Services;

use GuzzleHttp\Client;
use Jooyeshgar\Moadian\Exceptions\MoadianException;
use Jooyeshgar\Moadian\Http\{Packet, ServerInfoPacket, GetTokenPacket, FiscalInfoPacket, InquiryByReferenceNumber, InquiryByUid, Response};

class ApiClient
{
    private Client $httpClient;
    private SignatureService $signatureService;
    private EncryptionService $encryptionService;
    private $token;
    private Response $response;
    private $username;

    public function __construct($username, $privateKey, $baseUri = 'https://tp.tax.gov.ir/')
    {
        $this->httpClient = new Client([
            'base_uri' => $baseUri,
            'headers' => ['Content-Type' => 'application/json'],
        ]);
        $this->username = $username;
        $this->signatureService = new SignatureService($privateKey);
        $this->encryptionService = new EncryptionService();
        $this->response = new Response();
    }
    /**
     * Sends a packet to the API server.
     *
     * @param Packet $packet The packet to send.
     * @return mixed The response from the API server.
     */
    public function sendPacket(Packet $packet): Response
    {
        if($packet->needToken) $this->addToken($packet);
        $packet = $this->signPacket($packet);
        if($packet->needEncrypt) $packet = $this->encryptPacket($packet);

        $httpResp = $this->httpClient->post($packet->path, [
            'body' => $packet->getBody(),
            'headers' => $packet->getHeaders(),
        ]);

        return $this->response->setResponse($httpResp);
    }

    private function addToken(Packet $packet)
    {
        if(is_null($this->token)){
            $this->getToken();
        }
        return $packet->setToken($this->token);
    }

    public function getToken()
    {
        $packet = new GetTokenPacket();
        $packet->fiscalId = $this->username;
        $packet->data = ["username" => $this->username];

        $response = $this->sendPacket($packet);

        if($response->isSuccessful()){
            $result = $response->getBody();
            $this->token = $result['token'];
            return $this->token; 
        }

        throw new MoadianException('Unable to retrieve Token');
    }


    /**
     * Signs a packet with a digital signature.
     *
     * @param Packet $packet The packet to sign.
     * @return void
     */
    private function signPacket(Packet $packet)
    {
        $headers = $packet->getHeaders();
        if (isset($headers['authorization'])) {
            $headers['authorization'] = str_replace('Bearer ', '', $headers['authorization']);
        }

        $packet->signature = $this->signatureService->sign($packet->getPacket(), $headers);

        return $packet;
    }

    /**
     * Encrypts a packet with a symmetric encryption algorithm.
     *
     * @param Packet $packet The packet to encrypt.
     * @return void
     */
    private function encryptPacket(Packet $packet)
    {
        return $packet;
    }

    public function getServerInfo()
    {
        $packet = new ServerInfoPacket();
        return $this->sendPacket($packet);
    }

    public function requirePublicKey()
    {
        if(empty($this->encryptionService->publicKey)){
            $serverInfo = $this->getServerInfo();

            if($serverInfo->isSuccessful()){
                $info = $serverInfo->getBody();
                $this->encryptionService->KeyId = $info['publicKeys'][0]['id'];
                $pem = chunk_split($info['publicKeys'][0]['key'], 64, "\n");
                $this->encryptionService->publicKey = "-----BEGIN PUBLIC KEY-----\n".$pem."-----END PUBLIC KEY-----\n";
            }
        }
    }

    public function getFiscalInfo()
    {
        $packet = new FiscalInfoPacket($this->username);
        return $this->sendPacket($packet);
    }

    public function inquiryByUid(array $uids)
    {
        $packet = new InquiryByUid();
        foreach ($uids as $uid) {
            $packet->data[] = [
                'uid' => $uid,
                'fiscalId' => $this->username,
            ];
        }
        return $this->sendPacket($packet);
    }

    public function inquiryByReferenceNumber(array $refNums)
    {
        $packet = new InquiryByReferenceNumber($this->username);
        $packet->data = [
            'referenceNumber' => $refNums,
        ];

        return $this->sendPacket($packet);
    }
}
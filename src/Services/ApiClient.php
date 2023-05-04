<?php

namespace Jooyeshgar\Moadian\Services;

use GuzzleHttp\Client;
use Jooyeshgar\Moadian\Exceptions\MoadianException;
use Jooyeshgar\Moadian\Http\{EconomicCodeInformation, Packet, ServerInfoPacket, GetTokenPacket, FiscalInfoPacket, InquiryByReferenceNumber, InquiryByUid, invoicePacket, Response};
use Jooyeshgar\Moadian\Invoice;

class ApiClient
{
    private Client $httpClient;
    private SignatureService $signer;
    private EncryptionService $encryptor;
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
        $this->signer = new SignatureService($privateKey);
        $this->encryptor = new EncryptionService();
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

        $packet->signature = $this->signer->sign($packet->getPacket(), $headers);

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
        $this->requirePublicKey();

        $aesHex = bin2hex(random_bytes(32));
        $iv = bin2hex(random_bytes(16));
        
        $packet->iv = $iv;
        $packet->symmetricKey = $this->encryptor->encryptAesKey($aesHex);
        $packet->encryptionKeyId = $this->encryptor->KeyId;
        $packet->data = $this->encryptor->encrypt(json_encode($packet->data), hex2bin($aesHex), hex2bin($iv));

        return $packet;
    }

    public function getServerInfo()
    {
        $packet = new ServerInfoPacket();
        return $this->sendPacket($packet);
    }

    public function requirePublicKey()
    {
        if(empty($this->encryptor->publicKey)){
            $serverInfo = $this->getServerInfo();

            if($serverInfo->isSuccessful()){
                $info = $serverInfo->getBody();
                $this->encryptor->KeyId = $info['publicKeys'][0]['id'];
                $pem = chunk_split($info['publicKeys'][0]['key'], 64, "\n");
                $this->encryptor->publicKey = "-----BEGIN PUBLIC KEY-----\n".$pem."-----END PUBLIC KEY-----\n";
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

    public function inquiryByReferenceNumbers(array $refNums)
    {
        $packet = new InquiryByReferenceNumber($this->username);
        $packet->data = [
            'referenceNumber' => $refNums,
        ];

        return $this->sendPacket($packet);
    }

    public function getEconomicCodeInformation(string $taxID)
    {
        $packet = new EconomicCodeInformation($this->username);
        $packet->data = [
            'economicCode' => $taxID,
        ];

        return $this->sendPacket($packet);
    }

    public function sendInvoice(Invoice $moadianInvoice)
    {
        $packet = new invoicePacket();
        $packet->data = $moadianInvoice->toArray();

        return $this->sendPacket($packet);
    }
}

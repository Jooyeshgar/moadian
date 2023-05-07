<?php

namespace Jooyeshgar\Moadian\Services;

use GuzzleHttp\Client;
use Jooyeshgar\Moadian\Exceptions\MoadianException;
use Jooyeshgar\Moadian\Http\{EconomicCodeInformation, Packet, ServerInfoPacket, GetTokenPacket, FiscalInfoPacket, InquiryByReferenceNumber, InquiryByUid, invoicePacket, Request, Response};
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
    public function sendRequest(Request $request): Response
    {
        if($request->needToken) $this->addToken($request);
        if($request->getPacket()->needEncrypt) $this->encryptPacket($request->getPacket());
        $request = $this->signRequest($request);

        $httpResp = $this->httpClient->post($request->getPacket()->path, [
            'body' => $request->getBody(),
            'headers' => $request->getHeaders(),
        ]);

        return $this->response->setResponse($httpResp);
    }

    private function addToken(Request $request)
    {
        if(is_null($this->token)){
            $this->getToken();
        }
        return $request->setToken($this->token);
    }

    public function getToken()
    {
        $request = new Request();
        $request->setPacket(new GetTokenPacket($this->username));

        $response = $this->sendRequest($request);

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
    private function signRequest(Request $request)
    {
        $headers = $request->getHeaders();
        if (isset($headers['authorization'])) {
            $headers['authorization'] = str_replace('Bearer ', '', $headers['authorization']);
        }

        if ($request->getPackets() !== []) {
            $request->signature = $this->signer->sign(['packets' => [$request->getPacket()->toArray()]], $headers);
        } else {
            $request->signature = $this->signer->sign($request->getPacket()->toArray(), $headers);
        }

        return $request;
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
        $request = new Request();
        $request->setPacket(new ServerInfoPacket());
        return $this->sendRequest($request);
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
        $request = new Request();
        $request->setPacket(new FiscalInfoPacket($this->username));
        return $this->sendRequest($request);
    }

    public function inquiryByUid(array $uids)
    {
        $request = new Request();
        $request->setPacket(new InquiryByUid($uids, $this->username));
        return $this->sendRequest($request);
    }

    public function inquiryByReferenceNumbers(array $refNums)
    {
        $request = new Request();
        $request->setPacket(new InquiryByReferenceNumber($refNums, $this->username));

        return $this->sendRequest($request);
    }

    public function getEconomicCodeInformation(string $taxId)
    {
        $request = new Request();
        $request->setPacket(new EconomicCodeInformation($taxId));

        return $this->sendRequest($request);
    }

    public function sendInvoice(Invoice $moadianInvoice)
    {
        $request = new Request();
        $packet = new invoicePacket($this->username, $moadianInvoice);
        $packet->dataSignature = $this->signer->sign($moadianInvoice->toArray(), []);
        $request->setPackets([$packet]);

        return $this->sendRequest($request);
    }
}

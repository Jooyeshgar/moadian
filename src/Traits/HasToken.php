<?php

namespace Jooyeshgar\Moadian\Traits;

use Jooyeshgar\Moadian\Facades\Moadian;
use Jooyeshgar\Moadian\Services\SignatureService;

trait HasToken
{
    protected string $username;
    protected string $nonce;

    /**
     * Set credentials for token generation
     * 
     * @param string $username
     * @param string $nonce
     */
    public function setCredentials(string $username, string $nonce): void
    {
        $this->username = $username;
        $this->nonce = $nonce;
    }

    /**
     * Create authorization token
     * 
     * @param SignatureService $signer
     * 
     */
    public function addToken(SignatureService $signer)
    {
        $payload = [
            'nonce'    => $this->nonce,
            'clientId' => $this->username
        ];

        $token = $signer->sign($payload);

        $auth = 'Bearer ' . $token;
        $this->headers['authorization'] = $auth;
    }
}

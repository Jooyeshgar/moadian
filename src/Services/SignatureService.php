<?php

namespace Jooyeshgar\Moadian\Services;

use Carbon\Carbon;
use Firebase\JWT\JWT;

class SignatureService
{
    private string $privateKey;
    private string $x5c;

    public function __construct(string $privateKey, string $x5c)
    {
        $this->privateKey = $privateKey;
        $this->x5c = $x5c;
    }

    /**
     * Converts and signs a PHP array to JWS string
     */
    public function sign(array $payload, array $headers = [])
    {
        if (empty($headers)) {
            $headers = [
                'x5c'  => [$this->x5c],
                'sigT' => Carbon::now()->toIso8601ZuluString(),
                'crit' => ['sigT'],
                'cty'  => 'text/plain'
            ];
        }

        return JWT::encode(
            payload: $payload,
            key: $this->privateKey,
            alg: 'RS256',
            head: $headers
        );
    }
}

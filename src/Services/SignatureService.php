<?php

namespace Jooyeshgar\Moadian\Services;

use Jooyeshgar\Moadian\Exceptions\MoadianException;

class SignatureService
{
    private string $privateKey;

    public function __construct(string $privateKey)
    {
        $this->privateKey = $privateKey;
    }

    public function sign(array $data, array $headers)
    {
        $text = $this->normalizer($data, $headers);
        $signature = '';

        if (openssl_sign($text, $signature, $this->privateKey, OPENSSL_ALGO_SHA256)) {
            return base64_encode($signature);
        }
        else {
            throw new MoadianException('Failed to sign the text with message ' . openssl_error_string());
        }
    }


    public static function normalizer(array $data, array $headers): string
    {
        $data = $data + $headers;

        $normalizedData = [];

        $flatted = self::flattener($data);

        ksort($flatted);

        foreach ($flatted as $value) {

            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            if ($value === '' || $value === null) {
                $value = '#';
            }
            else {
                strtr($value, [ '#' => '##']);
            }

            $normalizedData[] = $value;
        }

        return implode("#", $normalizedData);
    }

    private static function flattener(array $array, string $prefix = ''): array {
        $flatted = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $flatted = array_merge($flatted, self::flattener($value, "$prefix.$key"));
            }
            else {
                $flatted["$prefix.$key"] = $value;
            }
        }
        return $flatted;
    }
}

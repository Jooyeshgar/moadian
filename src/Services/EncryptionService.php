<?php

namespace Jooyeshgar\Moadian\Services;

use Firebase\JWT\JWT;
use phpseclib3\Crypt\RSA;

class EncryptionService
{
    private const CIPHER = 'aes-256-gcm';
    private const TAG_LENGTH = 16;
    /**
     * @var		string	$publicKey Must be get by getServerInfo
     */
    public string $publicKey = '';
    /**
     * @var		string	$KeyId Must be get by getServerInfo
     */
    public string $KeyId = '';

    public function __construct($publicKey = '', $KeyId = '')
    {
        $this->publicKey = $publicKey;
        $this->KeyId = $KeyId;
    }

    public function encryptAesKey(string $aesKey): string
    {
        $rsa = RSA::loadPublicKey($this->publicKey);

        return $rsa->encrypt($aesKey);
    }

    /**
     * Encrypts the given invoice.
     * 
     * @param string $jws Signed invoice.
     * @param string $key The encryption key used for encryption in binary format.
     * @param string $iv The initialization vector (IV) used for encryption in binary format.
     * @return string Encrypted invoice packet.
     */
    public function encrypt(string $jws, string $key, string $iv): string
    {
        $segments = [];
        $header = [
            'alg' => 'RSA-OAEP-256',
            'enc' => 'A256GCM',
            'kid' => $this->KeyId
        ];

        $segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($header));
        $segments[] = JWT::urlsafeB64Encode($this->encryptAesKey($key));
        $segments[] = JWT::urlsafeB64Encode($iv);

        // Additional authenticated data
        $ascii = array_values(unpack('C*', $segments[0]));
        $aad = implode(array_map('chr', $ascii));

        $tag = '';
        $payload = openssl_encrypt($jws, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv, $tag, $aad, self::TAG_LENGTH);

        $segments[] = JWT::urlsafeB64Encode($payload);
        $segments[] = JWT::urlsafeB64Encode($tag);

        return implode('.', $segments);
    }
}

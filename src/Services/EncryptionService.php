<?php

namespace Jooyeshgar\Moadian\Services;

use Jooyeshgar\Moadian\Exceptions\MoadianException;
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

        return base64_encode($rsa->encrypt($aesKey));
    }

    /**
     * Encrypts the given text using the provided key and initialization vector (IV).
     * 
     * @param string $text The plaintext to be encrypted.
     * @param string $key The encryption key used for encryption in binary format.
     * @param string $iv The initialization vector (IV) used for encryption in binary format.
     * @return string The base64-encoded encrypted ciphertext with authentication tag appended.
     */
    public function encrypt(string $text, string $key, string $iv): string
    {
        $text = $this->xorStrings($text, $key);

        $tag = '';

        $cipherText = openssl_encrypt($text, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv, $tag, "", self::TAG_LENGTH);

        // Return the base64-encoded encrypted ciphertext with the authentication tag appended
        return base64_encode($cipherText . $tag);
    }

    public function decrypt(string $encryptedText, string $key, string $iv, int $tagLen)
    {

    }

    public function xorStrings(string $source, string $key): string
    {
        $sourceLength = strlen($source);
        $keyLength = strlen($key);
        $result = '';
        for ($i = 0; $i < $sourceLength; $i++) {
            $result .= $source[$i] ^ $key[$i % $keyLength];
        }
        return $result;
    }

}

<?php

namespace Jooyeshgar\Moadian\Services;

use Jooyeshgar\Moadian\Exceptions\MoadianException;

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


    public function encrypt(string $text, string $key, string $iv)
    {

    }

    public function decrypt(string $encryptedText, string $key, string $iv, int $tagLen)
    {

    }

}

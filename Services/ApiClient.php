<?php

namespace Jooyeshgar\Moadian;

use Jooyeshgar\Moadian\Packet;

class ApiClient
{
    /**
     * Sends a packet to the API server.
     *
     * @param Packet $packet The packet to send.
     * @return mixed The response from the API server.
     */
    public function sendPacket(Packet $packet)
    {
        // TODO: Implement sending the packet to the API server.
    }

    /**
     * Signs a packet with a digital signature.
     *
     * @param Packet $packet The packet to sign.
     * @return void
     */
    private function signPacket(Packet $packet): void
    {
        // TODO: Implement signing the packet with a digital signature.
    }

    /**
     * Encrypts a packet with a symmetric encryption algorithm.
     *
     * @param Packet $packet The packet to encrypt.
     * @return void
     */
    private function encryptPacket(Packet $packet)
    {
        // TODO: Implement encrypting the packet with a symmetric encryption algorithm.
    }
}
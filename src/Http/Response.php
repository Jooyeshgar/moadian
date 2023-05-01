<?php

namespace Jooyeshgar\Moadian\Http;

class Response
{
    private $statusCode;
    private $error;
    private $body;

    public function setResponse($httpResponse)
    {
        $this->statusCode = $httpResponse->getStatusCode();

        if ($this->statusCode >= 400) {
            $this->error = $httpResponse->getBody()->getContents();
            $this->body = $this->parseJson($this->error);
        } else {
            $this->body = $httpResponse->getBody()->getContents();
            $this->body = $this->parseJson($this->body);
        }

        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function isSuccessful()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    private function parseJson($json)
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Handle JSON parsing error
            return [
                'error' => 'Failed to parse response as JSON',
                'raw' => $json,
            ];
        }
        if(isset($data['result']['data'])){
            return $data['result']['data'];
        }

        return [
            'error' => 'Response does not contain a "result.data" field',
            'raw' => $data,
        ];
    }
}
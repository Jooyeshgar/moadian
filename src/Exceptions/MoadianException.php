<?php

namespace Jooyeshgar\Moadian\Exceptions;

use Exception;

class MoadianException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
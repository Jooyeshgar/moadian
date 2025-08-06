<?php

namespace Jooyeshgar\Moadian\Traits;

use Jooyeshgar\Moadian\Facades\Moadian;
use Jooyeshgar\Moadian\Services\SignatureService;

trait SetFromArray
{
    /**
     * Set data from array
     */
    public function setData(array $data): void
    {
        $vars = array_keys(get_class_vars(get_class($this)));
        $vars = array_diff($vars, $this->excludedMap ?? []);
        foreach ($vars as $var) {
            if (array_key_exists($var, $data)) {
                $this->{$var} = $data[$var];
            }
        }
    }
}

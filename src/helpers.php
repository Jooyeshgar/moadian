<?php
if (!function_exists("get_public_class_vars")) {
    function get_public_class_vars(string $class): array
    {
        return get_class_vars($class);
    }
}

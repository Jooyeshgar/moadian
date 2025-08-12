<?php
/**
 * Return only public property from a class
 */
if (!function_exists("get_public_class_vars")) {
    function get_public_class_vars(string $class): array
    {
        return get_class_vars($class);
    }
}

/**
 * Return only public property from an object
 */
if (!function_exists("get_public_object_vars")) {
    function get_public_object_vars($object): array
    {
        return get_object_vars($object);
    }
}
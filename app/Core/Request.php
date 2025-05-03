<?php

/**
 * Class Request
 *
 * Encapsulates an HTTP request, providing easy access to GET, POST, COOKIE data,
 * URL parameters, and request headers. This class manages the input data of an
 * HTTP request and provides methods to work with them.
 *
 * @package Bitka
 * @author  Jan P. Behrens
 * @license MIT
 * @version 1.0.0
 */

namespace Bitka\Core;

class Request
{
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function path(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        return parse_url($uri, PHP_URL_PATH);
    }

    public function get(string $key, $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    public function post(string $key, $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }
}

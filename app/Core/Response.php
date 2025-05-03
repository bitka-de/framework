<?php

/**
 * Class Response
 *
 * Represents the HTTP response sent to the client. It allows setting the status code, adding headers, and sending data (e.g., HTML, JSON).
 * The `Response` class provides a centralized way to format and send the response of an HTTP request.
 *
 * @package Bitka
 * @author  Jan P. Behrens
 * @license MIT
 * @version 1.0.0
 */

namespace Bitka\Core;

class Response
{

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function setHeader(string $name, string $value): void
    {
        header("$name: $value");
    }

    public function setContent(string $content): self
    {
        echo $content;
        return $this;
    }
}

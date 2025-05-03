<?php
function config(string $key, mixed $default = null): mixed
{
    static $configs = [];

    [$file, $item] = explode('.', $key);

    $path = __DIR__ . "/../config/{$file}.php";

    if (!isset($configs[$file])) {
        if (!file_exists($path)) {
            throw new RuntimeException("Config file not found: {$file}");
        }

        $configs[$file] = require $path;
    }

    return $configs[$file][$item] ?? $default;
}

function _env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? getenv($key) ?? $default;
}

function assets(string $path)
{

}

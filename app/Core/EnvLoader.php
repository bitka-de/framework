<?php

namespace Bitka\Core;

class EnvLoader
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = rtrim($path, '/');
    }

    public function load(string $filename = '.env'): void
    {
        $filepath = "{$this->path}/{$filename}";
        if (!file_exists($filepath)) {
            throw new \RuntimeException(".env file not found at: {$filepath}");
        }

        $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Kommentare ignorieren
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            // KEY=VALUE aufteilen
            if (strpos($line, '=') !== false) {
                [$name, $value] = explode('=', $line, 2);

                $name  = trim($name);
                $value = trim($value);

                // Entferne umgebende Anführungszeichen
                $value = preg_replace('/^["\'](.*)["\']$/', '$1', $value);

                // Typ bestimmen
                $value = $this->castValue($value);

                // Nur setzen, wenn nicht bereits gesetzt
                if (!isset($_ENV[$name]) && getenv($name) === false) {
                    putenv("{$name}={$value}");
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }

    private function castValue(string $value): mixed
    {
        // Boolean-Werte
        if (strtolower($value) === 'true') {
            return true;
        }
        if (strtolower($value) === 'false') {
            return false;
        }

        // Numerische Werte
        if (is_numeric($value)) {
            return $value + 0; // Konvertiert zu int oder float
        }

        // Standard: String
        return $value;
    }
}

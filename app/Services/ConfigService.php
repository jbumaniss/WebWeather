<?php

namespace App\Services;

class ConfigService
{
    public function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}

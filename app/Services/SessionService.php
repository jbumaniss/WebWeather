<?php

namespace App\Services;

class SessionService
{
    public function get(string $key, string $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }
}

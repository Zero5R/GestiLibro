<?php

namespace App\Libraries;

class AuthUser
{
    private static $instance = null;
    private $userData;

    private function __construct() {}

    public static function getInstance(): AuthUser
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setUser(array $data)
    {
        $this->userData = $data;
    }

    public function getUser(): ?array
    {
        return $this->userData;
    }

    public function isLoggedIn(): bool
    {
        return !empty($this->userData);
    }

    public function logout()
    {
        $this->userData = null;
        self::$instance = null;
    }
}

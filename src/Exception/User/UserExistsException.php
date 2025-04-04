<?php

namespace App\Exception\User;

class UserExistsException extends \Exception
{
    public function __construct(
        private readonly string $username
    ) {
        parent::__construct();
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
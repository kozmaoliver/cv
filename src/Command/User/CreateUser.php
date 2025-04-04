<?php

namespace App\Command\User;

class CreateUser
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }
}
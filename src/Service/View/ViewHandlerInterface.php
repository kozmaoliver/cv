<?php

namespace App\Service\View;

interface ViewHandlerInterface
{
    public function handle(
        mixed $data,
    );
}
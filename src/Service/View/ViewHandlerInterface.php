<?php

namespace App\Service\View;

use App\Service\View\Context\ViewContext;
use App\Service\View\Context\ViewContextInterface;

interface ViewHandlerInterface
{
    public function handle(
        mixed $data,
        ViewContextInterface $context = new ViewContext(),
    );

}

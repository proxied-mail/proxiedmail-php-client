<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Client;

interface ResponseInterface
{
    public function getResponseJson(): array;
}

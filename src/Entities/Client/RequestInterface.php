<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Client;

interface RequestInterface
{
    public function getMethod(): string;

    public function getUrl(): string;

    public function getPayload(): array;

    public function getHeaders(): array;
}

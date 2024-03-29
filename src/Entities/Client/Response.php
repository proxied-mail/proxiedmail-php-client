<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Client;

class Response implements ResponseInterface
{
    /**
     * @var array
     */
    private array $responseJson;

    public function __construct(array $responseJson)
    {
        $this->responseJson = $responseJson;
    }

    public function getResponseJson(): array
    {
        return $this->responseJson;
    }
}

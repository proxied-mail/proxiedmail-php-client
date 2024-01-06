<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\GetApiTokenResponseMapper;
use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;

class GetApiTokenEndpoint implements EndpointInterface
{
    public function getMethod(): string
    {
        return self::METHOD_GET;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'api-token';
    }

    public function getPayload(array $arguments = []): array
    {
        return [];
    }

    public function getMapper(): MapperInterface
    {
        return new GetApiTokenResponseMapper();
    }
}

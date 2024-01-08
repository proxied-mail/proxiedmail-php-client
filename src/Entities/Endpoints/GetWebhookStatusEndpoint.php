<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\CreateWebhookResponseMapper;
use ProxiedMail\Client\Transformers\ResponseMappers\GetWebhookResponseMapper;
use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;

class GetWebhookStatusEndpoint implements EndpointInterface
{
    public function getMethod(): string
    {
        return self::METHOD_GET;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'callback/get/' . $urlParams['id'];
    }

    public function getPayload(array $arguments = []): array
    {
        return [];
    }

    public function getMapper(): MapperInterface
    {
        return new GetWebhookResponseMapper();
    }
}

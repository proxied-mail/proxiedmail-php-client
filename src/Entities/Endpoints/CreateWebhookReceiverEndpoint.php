<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\CreateWebhookResponseMapper;
use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;

class CreateWebhookReceiverEndpoint implements EndpointInterface
{
    public function getMethod(): string
    {
        return self::METHOD_POST;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'callback';
    }

    public function getPayload(array $arguments = []): array
    {
        return [];
    }

    public function getMapper(): MapperInterface
    {
        return new CreateWebhookResponseMapper();
    }
}

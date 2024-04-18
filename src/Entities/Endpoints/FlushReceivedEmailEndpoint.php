<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;
use ProxiedMail\Client\Transformers\ResponseMappers\NullableResponseMapper;
use ProxiedMail\Client\Transformers\ResponseMappers\ProxyBindingCreateResponseMapper;

class FlushReceivedEmailEndpoint implements EndpointInterface
{
    private NullableResponseMapper $nullableResponseMapper;

    public function __construct(NullableResponseMapper $nullableResponseMapper)
    {
        $this->nullableResponseMapper = $nullableResponseMapper;
    }

    public function getMethod(): string
    {
        return self::METHOD_POST;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'received-emails/' . $urlParams['id'] . '/flush';
    }

    public function getPayload(array $arguments = []): array
    {
        return [];
    }

    public function getMapper(): MapperInterface
    {
        return $this->nullableResponseMapper;
    }
}

<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;
use ProxiedMail\Client\Transformers\ResponseMappers\ProxyBindingsResponseMapper;

class GetProxyEmailsEndpoint implements EndpointInterface
{
    private ProxyBindingsResponseMapper $proxyBindingsResponseMapper;

    public function __construct(ProxyBindingsResponseMapper $proxyBindingsResponseMapper)
    {
        $this->proxyBindingsResponseMapper = $proxyBindingsResponseMapper;
    }

    public function getMethod(): string
    {
        return self::METHOD_GET;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'proxy-bindings';
    }

    public function getPayload(array $arguments = []): array
    {
        return [];
    }

    public function getMapper(): MapperInterface
    {
        return $this->proxyBindingsResponseMapper;
    }
}

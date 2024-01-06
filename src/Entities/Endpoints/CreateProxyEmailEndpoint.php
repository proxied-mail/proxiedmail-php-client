<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;
use ProxiedMail\Client\Transformers\ResponseMappers\ProxyBindingCreateResponseMapper;

class CreateProxyEmailEndpoint implements EndpointInterface
{
    private ProxyBindingCreateResponseMapper $bindingCreateResponseMapper;

    public function __construct(ProxyBindingCreateResponseMapper $bindingCreateResponseMapper)
    {
        $this->bindingCreateResponseMapper = $bindingCreateResponseMapper;
    }

    public function getMethod(): string
    {
        return self::METHOD_POST;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'proxy-bindings';
    }

    public function getPayload(array $arguments = []): array
    {
        return [
            'data' => [
                'type' => 'proxy_bindings',
                'attributes' => [
                    'real_addresses' => $arguments['real_addresses'],
                    'proxy_address' => $arguments['proxy_address'],
                    'callback_url' => $arguments['callback_url'],
                    'description' => $arguments['description'],
                ],
            ],
        ];
    }

    public function getMapper(): MapperInterface
    {
        return $this->bindingCreateResponseMapper;
    }
}

<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;
use ProxiedMail\Client\Transformers\ResponseMappers\ProxyBindingCreateResponseMapper;

class UpdateProxyEmailsEndpoint implements EndpointInterface
{
    private ProxyBindingCreateResponseMapper $bindingCreateResponseMapper;

    public function __construct(ProxyBindingCreateResponseMapper $bindingCreateResponseMapper)
    {
        $this->bindingCreateResponseMapper = $bindingCreateResponseMapper;
    }

    public function getMethod(): string
    {
        return self::METHOD_PATCH;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'proxy-bindings/' . $urlParams['id'];
    }

    public function getPayload(array $arguments = []): array
    {
        return [
            'data' => [
                'id' => $arguments['id'],
                'type' => 'proxy_bindings',
                'attributes' => [
                    'real_addresses' => array_reduce(
                        $arguments['real_addresses'],
                        function (array $carry, string $realAddress) {
                            $carry[$realAddress] = [
                                'is_enabled' => true,
                                'is_verified' => true,
                            ];
                            return $carry;
                        },
                        []
                    ),
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

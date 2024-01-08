<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\AuthResponseMapper;
use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;

class AuthEndpoint implements EndpointInterface
{
    public function getMethod(): string
    {
        return self::METHOD_POST;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'auth';
    }

    public function getPayload(array $arguments = []): array
    {
        return [
            'data' => [
                'type' => 'auth-request',
                'attributes' => [
                    'username' => $arguments['username'],
                    'password' => $arguments['password'],
                ],
            ],
        ];
    }

    public function getMapper(): MapperInterface
    {
        return new AuthResponseMapper();
    }
}

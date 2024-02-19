<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;
use ProxiedMail\Client\Transformers\ResponseMappers\NullableResponseMapper;
use ProxiedMail\Client\Transformers\ResponseMappers\ProxyBindingCreateResponseMapper;

class SendMessageInternalEndpoint implements EndpointInterface
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
        return self::API_V1 . 'send-message';
    }

    public function getPayload(array $arguments = []): array
    {
        return [
            'name' => $arguments['name'],
            'email' => $arguments['to'],
            'message' => $arguments['message'],
        ];
    }

    public function getMapper(): MapperInterface
    {
        return $this->nullableResponseMapper;
    }
}

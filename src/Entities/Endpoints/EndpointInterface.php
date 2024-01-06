<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;

interface EndpointInterface
{
    const METHOD_POST = 'POST';
    const METHOD_PATCH = 'PATCH';
    const METHOD_GET = 'GET';


    const API_V1 = '/api/v1/';

    public function getMethod(): string;
    public function getUrl(array $urlParams = []): string;
    public function getPayload(array $arguments = []): array;
    public function getMapper(): MapperInterface;
}

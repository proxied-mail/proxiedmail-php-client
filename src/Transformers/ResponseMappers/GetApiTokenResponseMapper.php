<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ApiTokenEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ResponseEntityInterface;

class GetApiTokenResponseMapper implements MapperInterface
{
    public function map(ResponseInterface $response): ResponseEntityInterface
    {
        $json = $response->getResponseJson();

        return new ApiTokenEntity($json['token']);
    }
}

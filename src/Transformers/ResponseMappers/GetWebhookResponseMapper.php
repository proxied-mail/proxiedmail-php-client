<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ResponseEntityInterface;
use ProxiedMail\Client\Entities\ResponseEntity\WebhookStatusEntity;

class GetWebhookResponseMapper implements MapperInterface
{
    public function map(ResponseInterface $response): ResponseEntityInterface
    {
        $json = $response->getResponseJson();

        return new WebhookStatusEntity(
            $json['payload'],
            $json['method'],
            $json['is_received']
        );
    }
}

<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ResponseEntityInterface;
use ProxiedMail\Client\Entities\ResponseEntity\WebhookReceiverEntity;

class CreateWebhookResponseMapper implements MapperInterface
{
    public function map(ResponseInterface $response): ResponseEntityInterface
    {
        $json = $response->getResponseJson();

        return new WebhookReceiverEntity(
            $json['call_url'],
            $json['get_url'],
            $json['id'],
        );
    }
}

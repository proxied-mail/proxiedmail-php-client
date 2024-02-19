<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingsCollectionEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailDetailsEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailDetailsEntityCollection;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailLinkEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailLinksEntityCollection;

class ReceivedEmailsDetailsResponseMapper implements MapperInterface
{
    public function map(ResponseInterface $response): ReceivedEmailDetailsEntity
    {
        $data = $response->getResponseJson();
        $item = $data['data'];

        $carry = new ReceivedEmailDetailsEntity(
            $item['id'],
            $item['attributes']['recipient_email'],
            $item['attributes']['sender_email'],
            $item['attributes']['subject'],
            $item['attributes']['attachments'],
            $item['attributes']['payload'],
            $item['attributes']['is_processed'],
            $item['attributes']['created_at']
        );

        return $carry;
    }
}
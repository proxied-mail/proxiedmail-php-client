<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingsCollectionEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailLinkEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailLinksEntityCollection;

class ReceivedEmailsLinksResponseMapper implements MapperInterface
{
    public function map(ResponseInterface $response): ReceivedEmailLinksEntityCollection
    {
        $data = $response->getResponseJson();

        $list = array_reduce($data['data'], function (array $carry, array $item) {
            $carry[] = new ReceivedEmailLinkEntity(
                $item['id'],
                $item['attributes']['recipient_email'],
                $item['attributes']['sender_email'],
                $item['attributes']['subject'],
                $item['attributes']['attachmentsCounter'],
                $item['attributes']['link'],
                $item['attributes']['is_processed'],
                $item['attributes']['created_at']
            );
            return $carry;
        }, []);

        return new ReceivedEmailLinksEntityCollection(...$list);
    }
}
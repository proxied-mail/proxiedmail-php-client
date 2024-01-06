<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingEntity;
use ProxiedMail\Client\Entities\ResponseEntity\RealAddressDetailedCollectionEntity;
use ProxiedMail\Client\Entities\ResponseEntity\RealAddressDetailedEntity;

class ProxyBindingSingleDataResponseMapper
{
    public function map(array $data): ProxyBindingEntity
    {
        $realAddresses = $data['attributes']['real_addresses'];
        $realEmailsMapped = array_reduce(
            array_keys($realAddresses),
            function (array $carry, string $key) use ($realAddresses) {
                $item = $realAddresses[$key];
                $carry[] = new RealAddressDetailedEntity(
                    $key,
                    $item['is_enabled'],
                    $item['is_verified']
                );

                return $carry;
            }, []);

        return new ProxyBindingEntity(
            $data['id'],
            new RealAddressDetailedCollectionEntity(...$realEmailsMapped),
            $data['attributes']['proxy_address'],
            $data['attributes']['received_emails'],
            $data['attributes']['type'],
            $data['attributes']['description'],
            $data['attributes']['callback_url'],
            $data['attributes']['created_at'],
            $data['attributes']['updated_at']
        );
    }
}
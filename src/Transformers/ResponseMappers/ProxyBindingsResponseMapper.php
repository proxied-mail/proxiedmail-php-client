<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingsCollectionEntity;

class ProxyBindingsResponseMapper implements MapperInterface
{
    private ProxyBindingSingleDataResponseMapper $bindingSingleDataResponseMapper;

    public function __construct(ProxyBindingSingleDataResponseMapper $bindingSingleDataResponseMapper)
    {
        $this->bindingSingleDataResponseMapper = $bindingSingleDataResponseMapper;
    }

    public function map(ResponseInterface $response): ProxyBindingsCollectionEntity
    {
        $data = $response->getResponseJson();

        $list = array_reduce($data['data'], function (array $carry, array $item) {
            $carry[] = $this->bindingSingleDataResponseMapper->map($item);
            return $carry;
        }, []);

        return new ProxyBindingsCollectionEntity(...$list);
    }
}
<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingEntity;

class ProxyBindingCreateResponseMapper implements MapperInterface
{
    private ProxyBindingSingleDataResponseMapper $bindingSingleDataResponseMapper;

    public function __construct(ProxyBindingSingleDataResponseMapper $bindingSingleDataResponseMapper)
    {
        $this->bindingSingleDataResponseMapper = $bindingSingleDataResponseMapper;
    }

    public function map(ResponseInterface $response): ProxyBindingEntity
    {
        $data = $response->getResponseJson();
        $pb = $this->bindingSingleDataResponseMapper->map($data['data']);

        return $pb;
    }
}
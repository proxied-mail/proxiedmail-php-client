<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\NullableEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ResponseEntityInterface;

class NullableResponseMapper implements MapperInterface
{
    public function map(ResponseInterface $response): ResponseEntityInterface
    {
        return new NullableEntity();
    }
}

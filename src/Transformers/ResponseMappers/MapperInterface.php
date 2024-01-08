<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ResponseEntityInterface;

interface MapperInterface
{
    public function map(ResponseInterface $response): ResponseEntityInterface;
}

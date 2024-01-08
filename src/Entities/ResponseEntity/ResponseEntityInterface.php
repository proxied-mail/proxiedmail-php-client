<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

interface ResponseEntityInterface
{
    public function getType(): string;
}

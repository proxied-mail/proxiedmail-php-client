<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class ApiTokenEntity implements ResponseEntityInterface
{
    public const TYPE = 'api-token';

    private string $token;

    public function __construct(
        string $token
    ) {
        $this->token = $token;
    }

    public function getApiToken(): string
    {
        return $this->token;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}

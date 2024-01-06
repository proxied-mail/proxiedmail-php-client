<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class OauthAccessTokenEntity implements ResponseEntityInterface
{
    public const TYPE = 'oauth-access-tokens';

    private string $token;

    public function __construct(
        string $token
    ) {
        $this->token = $token;
    }

    public function getBearerToken(): string
    {
        return $this->token;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}

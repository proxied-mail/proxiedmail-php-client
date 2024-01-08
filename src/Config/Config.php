<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Config;

class Config
{
    public const DEFAULT_HOST = 'https://proxiedmail.com';

    private string $host;

    private ?string $apiToken;

    private ?string $bearerToken;

    public function __construct(
        ?string $host = self::DEFAULT_HOST,
        ?string $apiToken = null,
        ?string $bearerToken = null
    ) {
        $this->host = $host;
        $this->apiToken = $apiToken;
        $this->bearerToken = $bearerToken;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string|null
     */
    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    /**
     * @return string|null
     */
    public function getBearerToken(): ?string
    {
        return $this->bearerToken;
    }

    /**
     * @param string|null $apiToken
     * @return Config
     */
    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;
        return $this;
    }

    /**
     * @param string|null $bearerToken
     * @return Config
     */
    public function setBearerToken(?string $bearerToken): self
    {
        $this->bearerToken = $bearerToken;
        return $this;
    }
}

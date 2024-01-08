<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class WebhookStatusEntity implements ResponseEntityInterface
{
    public const TYPE = 'webhook-status';

    private $payload;

    private ?string $method;

    private bool $isReceived;

    public function __construct(
        $payload,
        ?string $method,
        bool $isReceived
    ) {
        $this->payload = $payload;
        $this->method = $method;
        $this->isReceived = $isReceived;
    }

    public function isReceived(): bool
    {
        return $this->isReceived;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}

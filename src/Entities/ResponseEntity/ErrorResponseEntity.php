<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class ErrorResponseEntity implements ResponseEntityInterface
{
    public const TYPE = 'errors';

    private string $message;

    public function __construct(
        string $message
    ) {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}

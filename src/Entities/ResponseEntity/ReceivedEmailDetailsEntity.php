<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class ReceivedEmailDetailsEntity implements ResponseEntityInterface
{
    public const TYPE = 'received_emails_details';

    private string $id;

    private string $recipientEmail;

    private string $senderEmail;

    private string $subject;

    private array $attachments;

    private array $payload;

    private bool $isProcessed;

    private string $createdAt;

    public function __construct(
        string $id,
        string $recipientEmail,
        string $senderEmail,
        string $subject,
        array $attachments,
        array $payload,
        bool $isProcessed,
        string $createdAt
    ) {
        $this->id = $id;
        $this->recipientEmail = $recipientEmail;
        $this->senderEmail = $senderEmail;
        $this->subject = $subject;
        $this->attachments = $attachments;
        $this->payload = $payload;
        $this->isProcessed = $isProcessed;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRecipientEmail(): string
    {
        return $this->recipientEmail;
    }

    public function getSenderEmail(): string
    {
        return $this->senderEmail;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function isProcessed(): bool
    {
        return $this->isProcessed;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }


    public function getType(): string
    {
        return self::TYPE;
    }
}

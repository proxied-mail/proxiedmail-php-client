<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class ReceivedEmailLinkEntity implements ResponseEntityInterface
{
    public const TYPE = 'received_emails_link';

    private string $id;

    private string $recipientEmail;

    private string $senderEmail;

    private string $subject;

    private int $attachmentsCounter;

    private string $link;

    private bool $isProcessed;

    private string $createdAt;

    public function __construct(
        string $id,
        string $recipientEmail,
        string $senderEmail,
        string $subject,
        int $attachmentsCounter,
        string $link,
        bool $isProcessed,
        string $createdAt
    ) {
        $this->id = $id;
        $this->recipientEmail = $recipientEmail;
        $this->senderEmail = $senderEmail;
        $this->subject = $subject;
        $this->attachmentsCounter = $attachmentsCounter;
        $this->link = $link;
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

    public function getAttachmentsCounter(): int
    {
        return $this->attachmentsCounter;
    }

    public function getLink(): string
    {
        return $this->link;
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

<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class ReceivedEmailLinksEntityCollection implements ResponseEntityInterface
{
    public const TYPE = 'received_emails_link';

    /**
     * @var ReceivedEmailLinkEntity[]
     */
    private array $receivedEmailLinks;

    public function __construct(ReceivedEmailLinkEntity...$receivedEmailLinks)
    {
        $this->receivedEmailLinks = $receivedEmailLinks;
    }

    public function getReceivedEmailLinks(): array
    {
        return $this->receivedEmailLinks;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}

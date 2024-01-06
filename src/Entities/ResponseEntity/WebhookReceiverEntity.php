<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class WebhookReceiverEntity implements ResponseEntityInterface
{
    public const TYPE = 'webhook-receiver';

    private string $callUrl;

    private string $getUrl;

    private string $id;

    public function __construct(
        string $callUrl,
        string $getUrl,
        string $id
    ) {
        $this->callUrl = $callUrl;
        $this->getUrl = $getUrl;
        $this->id = $id;
    }


    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return string
     */
    public function getCallUrl(): string
    {
        return $this->callUrl;
    }

    /**
     * @return string
     */
    public function getGetUrl(): string
    {
        return $this->getUrl;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}

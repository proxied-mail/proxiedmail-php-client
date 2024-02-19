<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class ProxyBindingEntity implements ResponseEntityInterface
{
    public const TYPE = 'proxy-bindings';

    private string $id;

    private RealAddressDetailedCollectionEntity $addressDetailedCollectionEntity;

    private string $proxyAddress;

    private int $receivedEmails;

    private string $description;

    private string $callbackUrl;

    private string $createdAt;

    private string $updatedAt;

    private int $type;

    private bool $isBrowsable;

    public function __construct(
        string $id,
        RealAddressDetailedCollectionEntity $addressDetailedCollectionEntity,
        string $proxyAddress,
        int $receivedEmails,
        int $type,
        string $description,
        string $callbackUrl,
        string $createdAt,
        string $updatedAt,
        bool $isBrowsable = false
    ) {
        $this->id = $id;
        $this->addressDetailedCollectionEntity = $addressDetailedCollectionEntity;
        $this->proxyAddress = $proxyAddress;
        $this->receivedEmails = $receivedEmails;
        $this->type = $type;
        $this->description = $description;
        $this->callbackUrl = $callbackUrl;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->isBrowsable = $isBrowsable;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function isBrowsable(): bool
    {
        return $this->isBrowsable;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return RealAddressDetailedCollectionEntity
     */
    public function getAddressDetailedCollectionEntity(): RealAddressDetailedCollectionEntity
    {
        return $this->addressDetailedCollectionEntity;
    }

    /**
     * @return string
     */
    public function getProxyAddress(): string
    {
        return $this->proxyAddress;
    }

    public function getTypeValue(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getReceivedEmails(): int
    {
        return $this->receivedEmails;
    }

    /**
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}

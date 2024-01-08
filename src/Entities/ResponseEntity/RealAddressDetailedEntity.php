<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class RealAddressDetailedEntity implements ResponseEntityInterface
{
    public const TYPE = 'real_addresses_groups';

    private string $address;

    private bool $isEnabled;

    private bool $isVerified;

    public function __construct(
        string $address,
        bool $isEnabled,
        bool $isVerified
    ) {
        $this->address = $address;
        $this->isEnabled = $isEnabled;
        $this->isVerified = $isVerified;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }
}

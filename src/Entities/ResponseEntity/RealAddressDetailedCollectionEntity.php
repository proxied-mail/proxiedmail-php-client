<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class RealAddressDetailedCollectionEntity implements ResponseEntityInterface
{
    public const TYPE = 'real_addresses_groups';

    private array $realAddresses;

    public function __construct(
        RealAddressDetailedEntity ...$realAddresses
    ) {
        $this->realAddresses = $realAddresses;
    }

    /**
     * @return RealAddressDetailedEntity[]
     */
    public function getRealAddresses(): array
    {
        return $this->realAddresses;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}

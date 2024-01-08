<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class ProxyBindingsCollectionEntity implements ResponseEntityInterface
{
    public const TYPE = 'proxy-bindings';

    /**
     * @var ProxyBindingEntity[]
     */
    private array $proxyBindings;

    public function __construct(ProxyBindingEntity ...$proxyBindings)
    {
        $this->proxyBindings = $proxyBindings;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return ProxyBindingEntity[]
     */
    public function getProxyBindings(): array
    {
        return $this->proxyBindings;
    }
}

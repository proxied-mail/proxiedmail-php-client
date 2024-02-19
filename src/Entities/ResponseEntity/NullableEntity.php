<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\ResponseEntity;

class NullableEntity implements ResponseEntityInterface
{
    public const TYPE = 'nullable_entity';

    public function getSomethingRandom(): string
    {
        return md5(uniqid() . time() . 'something');
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}

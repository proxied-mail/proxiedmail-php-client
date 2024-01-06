<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entrypoint;

use ProxiedMail\Client\Config\Config;
use ProxiedMail\Client\Core\InternalDi;
use ProxiedMail\Client\Facades\ApiFacade;

class PxdMailApinitializer
{
    public static function init(?Config $config = null): ApiFacade
    {
        $di = new InternalDi();
        if (!$config) {
            $config = new Config();
        }

        /**
         * @var ApiFacade $facade
         */
        $facade = $di
            ->b($di)
            ->b($config)
            ->create(ApiFacade::class);

        return $facade;
    }
}

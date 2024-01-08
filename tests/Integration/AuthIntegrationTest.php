<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Tests\Integration;

use ProxiedMail\Client\Config\Config;
use ProxiedMail\Client\Entities\ResponseEntity\OauthAccessTokenEntity;
use ProxiedMail\Client\Entrypoint\PxdMailApinitializer;

class AuthIntegrationTest extends IntegrationTestCase
{
    public function testGetBearerToken()
    {
        $r = $this->auth();

        $this->assertInstanceOf(OauthAccessTokenEntity::class, $r);
        $this->assertNotEmpty($r->getBearerToken());

    }

    public function testGetApiToken()
    {
        $r = $this->auth();
        $config = (new Config())->setBearerToken('Bearer ' . $r->getBearerToken());
        $facade = PxdMailApinitializer::init($config);

        $apiToken = $facade->getApiToken();

        $this->assertNotEmpty($apiToken->getApiToken());
    }

}

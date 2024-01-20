<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Tests\Integration;

use PHPUnit\Framework\TestCase as BaseTestCase;
use ProxiedMail\Client\Config\Config;
use ProxiedMail\Client\Core\InternalDi;
use ProxiedMail\Client\Entities\ResponseEntity\OauthAccessTokenEntity;
use ProxiedMail\Client\Entrypoint\PxdMailApinitializer;
use ProxiedMail\Client\Facades\ApiFacade;

class IntegrationTestCase extends BaseTestCase
{
    protected function envValue($name, $default = null)
    {
        return $this->parseEnv()[$name] ?? $default;
    }

    protected function auth(): OauthAccessTokenEntity
    {
        $email = $this->envValue('TESTS_AUTH_EMAIL');
        $pass = $this->envValue('TESTS_AUTH_PASSWORD');

        $api = PxdMailApinitializer::init();
        /**
         * @var OauthAccessTokenEntity $r
         */
        $r = $api->login($email, $pass);
        return $r;
    }

    protected function getApiReady(): ApiFacade
    {
        $r = $this->auth();
        $config = (new Config())->setBearerToken('Bearer ' . $r->getBearerToken());
        $facade = PxdMailApinitializer::init($config);

        $apiToken = $facade->getApiToken();
        $config = new Config();
        $config->setApiToken($apiToken->getApiToken());

        return PxdMailApinitializer::init($config);
    }


    private function parseEnv(): array
    {
        $env = file_get_contents(__DIR__ . '/../../.env');
        $envs = [];
        $lines = explode("\n", $env);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            if (empty($name) || empty($value)) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            $envs[$name] = $value;
        }

        return $envs;
    }
}

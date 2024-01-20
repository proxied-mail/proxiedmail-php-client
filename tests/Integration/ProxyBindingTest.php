<?php

declare(strict_types=1);

namespace ProxiedMail\Tests\Integration;

use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingEntity;
use ProxiedMail\Client\Entities\ResponseEntity\RealAddressDetailedCollectionEntity;

class ProxyBindingTest extends IntegrationTestCase
{
    public function testGetProxyBinding()
    {
        $api = $this->getApiReady();
        $wh = $api->getProxyEmails();

        /**
         * @var ProxyBindingEntity $pb
         */
        $pb = $wh->getProxyBindings()[0];

        $this->assertNotEmpty($pb->getId());
        $this->assertInstanceOf(RealAddressDetailedCollectionEntity::class, $pb->getAddressDetailedCollectionEntity());
        $this->assertNotEmpty($pb->getProxyAddress());
        $this->assertIsInt($pb->getReceivedEmails());
        $this->assertIsInt($pb->getTypeValue());
    }


    public function testCreateProxyBindingEmpty()
    {
        $api = $this->getApiReady();
        $pb = $api->createProxyEmail();

        $this->assertNotEmpty($pb->getId());
        $this->assertInstanceOf(RealAddressDetailedCollectionEntity::class, $pb->getAddressDetailedCollectionEntity());
        $this->assertNotEmpty($pb->getProxyAddress());
        $this->assertIsInt($pb->getReceivedEmails());
        $this->assertIsInt($pb->getTypeValue());
    }

    public function testCreateProxyBinding()
    {
        $api = $this->getApiReady();
        $pb = $api->createProxyEmail(
            [
                'blabla@proxiedmail-int.int',
            ],
            uniqid() . '@proxiedmail.com',
            null,
            null
        );

        $this->assertNotEmpty($pb->getId());
        $this->assertInstanceOf(RealAddressDetailedCollectionEntity::class, $pb->getAddressDetailedCollectionEntity());
        $this->assertNotEmpty($pb->getProxyAddress());
        $this->assertIsInt($pb->getReceivedEmails());
        $this->assertIsInt($pb->getTypeValue());
    }

    public function testUpdateProxyBinding()
    {
        $api = $this->getApiReady();
        $realAddresses = [
            'blabla@proxiedmail-int.int',
        ];
        $proxyEmail = uniqid() . '@proxiedmail.com';
        $description = 'description';

        $pb = $api->createProxyEmail(
            $realAddresses,
            $proxyEmail,
            null,
            null
        );
        $this->assertEmpty($pb->getDescription());
        $pb = $api->updateProxyEmail($pb->getId(), $realAddresses, $proxyEmail, null, $description);

        $this->assertNotEmpty($pb->getId());
        $this->assertEquals($pb->getDescription(), $description);
    }



}

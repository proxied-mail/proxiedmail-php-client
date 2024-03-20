<?php

declare(strict_types=1);

namespace Integration;

use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingEntity;
use ProxiedMail\Client\Entities\ResponseEntity\RealAddressDetailedCollectionEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailLinksEntityCollection;
use ProxiedMail\Client\Exceptions\InvalidApiResponseException;
use ProxiedMail\Tests\Integration\IntegrationTestCase;

class WaitUntilNewEmailTest extends IntegrationTestCase
{
    public function testReceivedEmailsListNull()
    {
        $api = $this->getApiReady();
        $api->createProxyEmail(
            [
                $api->generateInternalEmail(),
            ],
            null,
            null,
            null,
            true
        );
        $wh = $api->getProxyEmails();

        $pb = $wh->getProxyBindings()[0];
        $entity = $api->waitUntilNextEmail($pb->getId(), 1);

        $this->assertNull($entity);
    }

        public function testReceivedEmailsList()
    {
        $api = $this->getApiReady();
        $api->createProxyEmail(
            [
                $api->generateInternalEmail(),
            ],
            null,
            null,
            null,
            true
        );
        $wh = $api->getProxyEmails();

        $pb = $wh->getProxyBindings()[0];

        $api->internalSendMail('test', $pb->getProxyAddress(), 'Test');
        $entity = $api->waitUntilNextEmail($pb->getId());

        $email = $api->getReceivedEmailDetailsByReceivedEmailId($entity->getId());

        $payload = $email->getPayload();

        $this->assertNotEmpty($payload);
        $this->assertNotEmpty($payload['stripped-html']);
        $this->assertNotEmpty($payload['Content-Type']);
        $this->assertNotEmpty($payload['From']);
        $this->assertNotEmpty($payload['Sender']);
        $this->assertNotEmpty($payload['Subject']);
        $this->assertNotEmpty($payload['To']);
        $this->assertNotEmpty($payload['body-html']);
    }
}

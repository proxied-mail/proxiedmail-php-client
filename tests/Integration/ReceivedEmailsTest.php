<?php

declare(strict_types=1);

namespace ProxiedMail\Tests\Integration;

use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingEntity;
use ProxiedMail\Client\Entities\ResponseEntity\RealAddressDetailedCollectionEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailLinksEntityCollection;
use ProxiedMail\Client\Exceptions\InvalidApiResponseException;

class ReceivedEmailsTest extends IntegrationTestCase
{
    public function testReceivedEmailsNotBrowsableError()
    {
        $api = $this->getApiReady();
        $api->createProxyEmail();
        $wh = $api->getProxyEmails();

        $pb = $wh->getProxyBindings()[0];

        try {
             $api->getReceivedEmailsLinksByProxyEmailId($pb->getId());
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidApiResponseException::class, $e);
        }
    }

    public function testReceivedEmailsBrowsable()
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


        $emailsList = $api->getReceivedEmailsLinksByProxyEmailId($pb->getId());
        $this->assertInstanceOf(ReceivedEmailLinksEntityCollection::class, $emailsList);
        $this->assertEmpty($emailsList->getReceivedEmailLinks());
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
        mail($pb->getProxyAddress(), 'Test', 'Test message');
        sleep(10);


        $emailsList = $api->getReceivedEmailsLinksByProxyEmailId($pb->getId());
        $this->assertInstanceOf(ReceivedEmailLinksEntityCollection::class, $emailsList);
        $this->assertEmpty($emailsList->getReceivedEmailLinks());
    }
}

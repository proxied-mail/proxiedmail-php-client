<?php

declare(strict_types=1);

namespace Integration;

use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingEntity;
use ProxiedMail\Client\Entities\ResponseEntity\RealAddressDetailedCollectionEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailLinksEntityCollection;
use ProxiedMail\Client\Exceptions\InvalidApiResponseException;
use ProxiedMail\Tests\Integration\IntegrationTestCase;

class ReceivedEmailsNullableTest extends IntegrationTestCase
{
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

        sleep(10);

        $emailsList = $api->getReceivedEmailsLinksByProxyEmailId($pb->getId());

        $firstLink = $emailsList->first();
        $api->flushReceivedEmail($firstLink->getId());

        $emailsList = $api->getReceivedEmailsLinksByProxyEmailId($pb->getId());

        $details = $api->getReceivedEmailDetailsByReceivedEmailId($emailsList->first()->getId());
        $this->assertEquals([], $details->getPayload());
        $this->assertEquals(
            '',
            $details->getSubject()
        );
        $this->assertEquals(
            $firstLink->getRecipientEmail(),
            $details->getRecipientEmail()
        );
        $this->assertEquals(
            $firstLink->getSenderEmail(),
            $details->getSenderEmail()
        );
        $this->assertEquals(
            $firstLink->getId(),
            $details->getId()
        );
    }
}

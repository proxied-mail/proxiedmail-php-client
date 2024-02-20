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

        $api->internalSendMail('test', $pb->getProxyAddress(), 'Test');

        sleep(10);



        $emailsList = $api->getReceivedEmailsLinksByProxyEmailId($pb->getId());
        $this->assertInstanceOf(ReceivedEmailLinksEntityCollection::class, $emailsList);
        $this->assertNotEmpty($emailsList->getReceivedEmailLinks());


        $entity = $emailsList->getReceivedEmailLinks()[0];
        $this->assertNotEmpty($entity->getId());
        $this->assertNotEmpty($entity->getSubject());
        $this->assertNotEmpty($entity->getRecipientEmail());
        $this->assertEquals($entity->getAttachmentsCounter(), 0);
        $this->assertNotEmpty($entity->getLink());

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

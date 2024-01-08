<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Tests\Integration;

class WebhookTest extends IntegrationTestCase
{
    public function testWebhookCreate()
    {
        $api = $this->getApiReady();
        $wh = $api->createWebhook();

        $this->assertNotEmpty($wh->getCallUrl());
        $this->assertNotEmpty($wh->getGetUrl());
    }

    public function testWebhookStatusNotReceived()
    {
        $api = $this->getApiReady();
        $wh = $api->createWebhook();

        $status = $api->statusWebhook($wh->getId());

        $this->assertFalse($status->isReceived());
        $this->assertNull($status->getMethod());
        $this->assertNull($status->getPayload());
    }

    public function testWebhookStatusCallPost()
    {
        $api = $this->getApiReady();
        $wh = $api->createWebhook();

        //make a post call to $wh->call_url
        $url = $wh->getCallUrl();
        $data = [
            'key1' => 'value1',
            'key2' => 'value2'
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/json",
                'method' => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);
        file_get_contents($url, false, $context);


        $status = $api->statusWebhook($wh->getId());

        $this->assertTrue($status->isReceived());
        $this->assertEquals($status->getMethod(), 'POST');
        $this->assertEquals($status->getPayload(), $data);
    }
}

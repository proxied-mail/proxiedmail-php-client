<?php

use ProxiedMail\Client\Config\Config;
use ProxiedMail\Client\Entities\ResponseEntity\OauthAccessTokenEntity;
use ProxiedMail\Client\Entrypoint\PxdMailApinitializer;
use ProxiedMail\Client\Facades\ApiFacade;

require 'vendor/autoload.php';


// put here your ProxiedMail credentials
$email = 'example.com';
$pass = '1';

/**
 * @var ApiFacade $facade
 */
$facade = PxdMailApinitializer::init();
/**
 * @var OauthAccessTokenEntity $r
 */
$r = $facade->login($email, $pass);

//settings bearer token
$config = (new Config())->setBearerToken('Bearer ' . $r->getBearerToken());
$facade = PxdMailApinitializer::init($config);

//receiving API token by bearer token
$apiToken = $facade->getApiToken();

$config = new Config();

//setting API token
$config->setApiToken($apiToken->getApiToken());

$api = PxdMailApinitializer::init($config);

$wh = $api->createWebhook(); //creating webhook-receiver
$proxyEmail  = $api->createProxyEmail(
    [],
    null,
    $wh->getCallUrl() //specifying webhook url
);



// while (true) with 100 seconds limit
foreach(range(0, 100) as $non) {
    echo "PROXY-EMAIL: " . $proxyEmail->getProxyAddress() . "\n";
    echo "Send the email to this proxy-email to get email payload printed here";

    //checking webhook receiver
    $whStatus = $api->statusWebhook($wh->getId());

    echo "Webhook STATUS: \n";
    echo "Received: " . ($whStatus->isReceived() ? 'yes' : 'no') . "\n"; //printing webhook status

    //printing payload if received
    if ($whStatus->isReceived()) {
        echo "WEBHOOK PAYLOAD: \n";
        echo json_encode($whStatus->getPayload());
        break;
    }


    echo "\n";

    sleep(1);
}

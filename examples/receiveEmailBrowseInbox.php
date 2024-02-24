<?php

use ProxiedMail\Client\Config\Config;
use ProxiedMail\Client\Entities\ResponseEntity\OauthAccessTokenEntity;
use ProxiedMail\Client\Entrypoint\PxdMailApinitializer;
use ProxiedMail\Client\Facades\ApiFacade;

require 'vendor/autoload.php';


// put here your ProxiedMail credentials
$email = 'example@example.com';
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

$proxyEmail  = $api->createProxyEmail(
    [],
    null,
    null,
    null,
    true
);



// while (true) with 100 seconds limit
foreach(range(0, 180) as $non) {
    echo "PROXY-EMAIL: " . $proxyEmail->getProxyAddress() . "\n";
    echo "Time limit is 3 mins \n";
    echo "Send the email to this proxy-email to get email payload printed here \n";

    //checking webhook receiver

    $receivedEmails = $api->getReceivedEmailsLinksByProxyEmailId($proxyEmail->getId())->getReceivedEmailLinks();
    echo "Amount of received emails: " . count($receivedEmails) . "\n";
    foreach ($receivedEmails as $receivedEmail) {
        echo "Have received email: \n";
        var_dump($receivedEmail);

        echo "\n";
    }

    echo "\n";

    sleep(1);
}

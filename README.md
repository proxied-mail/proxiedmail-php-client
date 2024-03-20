# ProxiedMail PHP client

Welcome to [ProxiedMail](https://proxiedmail.com) API client.
You're welcome to [visit the docs](https://docs.proxiedmail.com).

[Packagist](https://packagist.org/packages/proxiedmail/php-client)

### Features

🔴 Authorization

🔴 Callback receiver (creating callback urls, read callback payload)

🔴 Proxy-emails CRUD (create, read, update, todo: delete)


### Installation

```bash
composer require proxiedmail/php-client
```

### Test run


If you want to run tests, make sure .env with credentials present. Copy command:
```bash
cp .env.dist .env
```

To run:
```bash
make test-run
```


## Getting started: receiving email to your application

Here in this example you can see how to receive sent email to your API.
The program will print email address created to receive your email message.

```
PROXY-EMAIL: 4bd6c97b9@proxiedmail.com
Webhook STATUS: 
Received: no
```

Then, just send the email to the printed address. When app receive your message, it will print the following:
```
PROXY-EMAIL: 4bd6c97b9@proxiedmail.com
Webhook STATUS: 
Received: yes
WEBHOOK PAYLOAD: 
{
   "id":"EB442408-D500-0000-00003CC8",
   "payload":{
      "Content-Type":"multipart\/alternative; boundary=\"000000000000714564060f56f6c2\"",
      "Date":"Sat, 20 Jan 2024 02:00:25 +0000",
      "Dkim-Signature":"DKIM",
      "From":"Alex Yatsenko <sender@gmail.com>",
      "Message-Id":"<CAJj9C9dVhSJZDwRDM-H=vhzPttpg253biEvabFtEHiS4wriK8A@mail.gmail.com>",
      "Mime-Version":"1.0",
      "Received":"by mail-wm1-f44.google.com with SMTP id 5b1f17b1804b1-40e9ffab5f2so10064475e9.1 for <4bd6c97b9@proxiedmail.com>; Fri, 19 Jan 2024 18:00:38 -0800 (PST)",
      "Subject":"hey mate",
      "To":"4bd6c97b9@proxiedmail.com",
      "X-Envelope-From":"sender@gmail.com",
      "X-Mailgun-Incoming":"Yes",
      "X-Received":"Received details",
      "body-html":"<div dir=\"ltr\">hey hey<\/div>\r\n",
      "body-plain":"hey hey\r\n",
      "domain":"proxiedmail.com",
      "from":"Alex Alex <sender@gmail.com>",
      "message-headers":"HEADERS JSON....",
      "recipient":"4bd6c97b9@proxiedmail.com",
      "sender":"sender@gmail.com",
      "signature":"....",
      "stripped-html":"<div dir=\"ltr\">hey hey<\/div>\n",
      "stripped-text":"hey hey",
      "subject":"hey mate",
      "timestamp":"1705716046",
      "token":"..."
   },
   "attachments":[
      
   ],
   "recipient":{
      "address":"4bd6c97b9@proxiedmail.com"
   },
   "receivedAt":"Sat Jan 20 2024 02:00:46 GMT+0000",
   "user":{
      "id":"1B3AAA43-11-0000-cc",
      "username":"username+t1@gmail.com",
      "token":"Bearer ...."
   }
}
```

The code to execute is the following

```php
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
```

To run the example above just create folder, install lib there via composer and
put it to the file (t.php), then run:
```bash
php t.php
```


### Examples


#### Authorization

```php
        <?php
        
        use ProxiedMail\Client\Config\Config;
        use ProxiedMail\Client\Entities\ResponseEntity\OauthAccessTokenEntity;
        use ProxiedMail\Client\Entrypoint\PxdMailApinitializer;
        use ProxiedMail\Client\Facades\ApiFacade;
        
        require 'vendor/autoload.php';
        
        $email = $this->envValue('TESTS_AUTH_EMAIL');
        $pass = $this->envValue('TESTS_AUTH_PASSWORD');

        /**
         * @var ApiFacade $facade
         */
        $facade = PxdMailApinitializer::init();
        /**
         * @var OauthAccessTokenEntity $r
         */
        $r = $facade->login($email, $pass);

        $config = (new Config())->setBearerToken('Bearer ' . $r->getBearerToken());
        $facade = PxdMailApinitializer::init($config);

        $apiToken = $facade->getApiToken();

        $config = new Config();
        $config->setApiToken($apiToken->getApiToken());

        $facade = PxdMailApinitializer::init($config)
```

#### Webhook

```php
<?php
        //it's $facade from the end of previous example
        $api = $this->getApiReady(); //let's imagine we have ApiFacade here 
        $wh = $api->createWebhook();

        $status = $api->statusWebhook($wh->getId());

        $status->isReceived(); // false
        $status->getMethod(); //null
        $status->getPayload(); //null


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

        $status->isReceived(); //true;
        $status->getMethod(); //POST
        $status->getPayload(); //same what we have in $data
```



#### Create proxy-email

```php
<?php
        $api = $this->getApiReady();

        $pb = $api->createProxyEmail(
            [
                'blabla@proxiedmail-int.int',
            ],
            uniqid() . '@proxiedmail.com',
            null,
            null
        );

        $pb->getId(); //string ID, A1131D57-6000-0000-00000BAE
        $pb->getAddressDetailedCollectionEntity(); //@see RealAddressDetailedCollectionEntity::class
        $pb->getProxyAddress(); //blabla@proxiedmail.com
        $pb->getReceivedEmails(); // 0
        $pb->getTypeValue(); // 0 - Regular, 1 - news
```


#### Proxy-emails list

```php
<?php
        $api = $this->getApiReady();
        $wh = $api->getProxyEmails();
        /**
         * @var ProxyBindingEntity $pb
         */
        $pb = $wh->getProxyBindings()[0];
```

#### List of received emails

Please note that you can see received emails only for proxy-emails with is_browsable opted as true.
You can still update is_browsable attribute when you don't when you don't have any received emails yet.

```php
<?php
        $api = $this->getApiReady();
        $api->createProxyEmail(
            [
                $api->generateInternalEmail(),
            ],
            null,
            null,
            null,
            true //opt in is_browsable
        );
        
        $wh = $api->getProxyEmails();
        /**
         * @var ProxyBindingEntity $pb
         */
        $pb = $wh->getProxyBindings()[0]; //pick up the last one we created

        $emailsList = $api->getReceivedEmailsLinksByProxyEmailId($pb->getId());

        $entity = $emailsList->getReceivedEmailLinks()[0];
        $receivedEmailId = $entity->getId();
        $subject = $entity->getSubject();
        $recipientEmail = $entity->getRecipientEmail();
        $attachmentCounter = $entity->getAttachmentsCounter();

        $emailDetails = $api->getReceivedEmailDetailsByReceivedEmailId($entity->getId());
        
        $payload = $email->getPayload();

        $strippedHtml = $payload['stripped-html'];
        $contentType = $payload['Content-Type'];
        $from = $payload['From'];
        $sender = $payload['Sender'];
        $subject = $payload['Subject'];
        $to = $payload['To'];
        $bodyHtml = $payload['body-html'];
```

Also you can try simplified version of it:
```php
        $entity = $api->waitUntilNextEmail($pb->getId()); //get by proxy email id
        $payload = $entity->getPayload();
```
But please pay attention that on the moment of the run email shouldn't be received yet.
Otherwise it's going to hugh for some time.


#### Other examples

Also see other examples in https://github.com/proxied-mail/proxiedmail-php-client/tree/main/tests/Integration

#### Auth advise

Authorize first with your email and password.
Then use received Bearer token to receive your API key.

You can also get your API token on "Settings" section in your ProxiedMail account: https://proxiedmail.com/en/settings .
You can hardcode this token to your application as it's have no expiration date.
Please text us if you want to revoke it.

#### Dependency Injection

As you may see we have DI built-in in our client to make less dependencies as it just a single class.


```php
<?php
        $api = PxdMailApinitializer::init();
        // OR
        $config = new Config('HOST', 'API_TOKEN', 'Bearer token'); //everything nullable
        $api = PxdMailApinitializer::init($config);
```

Please note that if you want to change config in terms of host, bearer or api token over program execution 
please RE-Initialize via `PxdMailApinitializer::init()` with new config object.

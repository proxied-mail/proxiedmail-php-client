# Proxiedmail-php-client

Welcome to ProxiedMail API client.
You're welcome to [visit the docs](https://docs.proxiedmail.com).

### Features

🔴 Authorization

🔴 Callback receiver (creating callback urls, read callback payload)

🔴 Proxy-emails CRUD (create, read, update, todo: delete)

### Installation

```bash
composer require proxiedmail/proxiedmail-php-client
```

### Examples


#### Authorization

```php
<?php
        $email = $this->envValue('TESTS_AUTH_EMAIL');
        $pass = $this->envValue('TESTS_AUTH_PASSWORD');

        $di = new InternalDi();

        /**
         * @var ApiFacade $facade
         */
        $facade = $di->b($di)->create(ApiFacade::class);
        /**
         * @var OauthAccessTokenEntity $r
         */
        $r = $facade->login($email, $pass);

        $config = (new Config())->setBearerToken('Bearer ' . $r->getBearerToken());
        $facade = PxdMailApinitializer::init($config);

        $apiToken = $facade->getApiToken();
```

#### Webhook

```php
<?php
        $api = $this->getApiReady();
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



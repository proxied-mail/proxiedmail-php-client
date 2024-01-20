# ProxiedMail PHP client

Welcome to [ProxiedMail](https://proxiedmail.com) API client.
You're welcome to [visit the docs](https://docs.proxiedmail.com).

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

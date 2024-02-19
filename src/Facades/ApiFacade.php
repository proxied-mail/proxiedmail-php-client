<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Facades;

use GuzzleHttp\Exception\GuzzleException;
use ProxiedMail\Client\Entities\Endpoints\AuthEndpoint;
use ProxiedMail\Client\Entities\Endpoints\CreateProxyEmailEndpoint;
use ProxiedMail\Client\Entities\Endpoints\CreateWebhookReceiverEndpoint;
use ProxiedMail\Client\Entities\Endpoints\GetApiTokenEndpoint;
use ProxiedMail\Client\Entities\Endpoints\GetProxyEmailsEndpoint;
use ProxiedMail\Client\Entities\Endpoints\GetReceivedEmailsDetails;
use ProxiedMail\Client\Entities\Endpoints\GetReceivedEmailsLinks;
use ProxiedMail\Client\Entities\Endpoints\GetWebhookStatusEndpoint;
use ProxiedMail\Client\Entities\Endpoints\SendMessageInternalEndpoint;
use ProxiedMail\Client\Entities\Endpoints\UpdateProxyEmailsEndpoint;
use ProxiedMail\Client\Entities\ResponseEntity\ApiTokenEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ErrorResponseEntity;
use ProxiedMail\Client\Entities\ResponseEntity\NullableEntity;
use ProxiedMail\Client\Entities\ResponseEntity\OauthAccessTokenEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingsCollectionEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailDetailsEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ReceivedEmailLinksEntityCollection;
use ProxiedMail\Client\Entities\ResponseEntity\ResponseEntityInterface;
use ProxiedMail\Client\Entities\ResponseEntity\WebhookReceiverEntity;
use ProxiedMail\Client\Entities\ResponseEntity\WebhookStatusEntity;
use ProxiedMail\Client\Exceptions\FacadeApiErrorException;
use ProxiedMail\Client\Services\EndpointService;

class ApiFacade
{
    private EndpointService $endpointService;

    private GetProxyEmailsEndpoint $getProxyEmailsEndpoint;

    private GetWebhookStatusEndpoint $getWebhookStatusEndpoint;

    private CreateWebhookReceiverEndpoint $createWebhookReceiverEndpoint;

    private GetApiTokenEndpoint $getApiTokenEndpoint;

    private AuthEndpoint $auth;

    private CreateProxyEmailEndpoint $createProxyEmailEndpoint;

    private UpdateProxyEmailsEndpoint $updateProxyEmails;

    private GetReceivedEmailsLinks $getReceivedEmailsLinks;

    private GetReceivedEmailsDetails $getReceivedEmailsDetails;

    private SendMessageInternalEndpoint $sendMessageInternalEndpoint;

    public function __construct(
        EndpointService $endpointService,
        GetProxyEmailsEndpoint $getProxyEmailsEndpoint,
        GetWebhookStatusEndpoint $getWebhookStatusEndpoint,
        CreateWebhookReceiverEndpoint $createWebhookReceiverEndpoint,
        GetApiTokenEndpoint $getApiTokenEndpoint,
        AuthEndpoint $authEndpoint,
        CreateProxyEmailEndpoint $createProxyEmailEndpoint,
        UpdateProxyEmailsEndpoint $updateProxyEmails,
        GetReceivedEmailsLinks $getReceivedEmailsLinks,
        GetReceivedEmailsDetails $getReceivedEmailsDetails,
        SendMessageInternalEndpoint $sendMessageInternalEndpoint
    ) {
        $this->endpointService = $endpointService;
        $this->getProxyEmailsEndpoint = $getProxyEmailsEndpoint;
        $this->getWebhookStatusEndpoint = $getWebhookStatusEndpoint;
        $this->createWebhookReceiverEndpoint = $createWebhookReceiverEndpoint;
        $this->getApiTokenEndpoint = $getApiTokenEndpoint;
        $this->auth = $authEndpoint;
        $this->createProxyEmailEndpoint = $createProxyEmailEndpoint;
        $this->updateProxyEmails = $updateProxyEmails;
        $this->getReceivedEmailsLinks = $getReceivedEmailsLinks;
        $this->getReceivedEmailsDetails = $getReceivedEmailsDetails;
        $this->sendMessageInternalEndpoint = $sendMessageInternalEndpoint;
    }

    /**
     * @param string $email
     * @param string $password
     * @return OauthAccessTokenEntity
     * @throws FacadeApiErrorException
     * @throws GuzzleException
     */
    public function login(string $email, string $password): OauthAccessTokenEntity
    {
        /**
         * @var OauthAccessTokenEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call($this->auth, [
            'username' => $email,
            'password' => $password,
        ]);
        $this->mapError($r);

        return $r;
    }

    public function getApiToken(): ApiTokenEntity
    {
        /**
         * @var ApiTokenEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call($this->getApiTokenEndpoint, []);
        $this->mapError($r);

        return $r;
    }

    public function createWebhook(): WebhookReceiverEntity
    {
        /**
         * @var WebhookReceiverEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call($this->createWebhookReceiverEndpoint, []);
        $this->mapError($r);

        return $r;
    }


    public function statusWebhook(string $id): WebhookStatusEntity
    {
        /**
         * @var WebhookStatusEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call(
            $this->getWebhookStatusEndpoint,
            [],
            [
                'id' => $id,
            ]);
        $this->mapError($r);

        return $r;
    }

    public function getProxyEmails(): ProxyBindingsCollectionEntity
    {
        /**
         * @var ProxyBindingsCollectionEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call(
            $this->getProxyEmailsEndpoint,
            []
        );
        $this->mapError($r);

        return $r;
    }

    public function createProxyEmail(
        array $realAddresses = [],
        ?string $proxyAddress = null,
        ?string $callbackUrl = null,
        ?string $description = null,
        bool $isBrowsable = false
    ): ProxyBindingEntity {
        /**
         * @var ProxyBindingEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call(
            $this->createProxyEmailEndpoint,
            [
                'real_addresses' => $realAddresses,
                'proxy_address' => $proxyAddress,
                'callback_url' => $callbackUrl ?? '',
                'description' => $description ?? '',
                'is_browsable' => $isBrowsable,
            ]
        );
        $this->mapError($r);

        return $r;
    }

    public function updateProxyEmail(
        string $id,
        array $realAddresses,
        string $proxyAddress,
        ?string $callbackUrl,
        ?string $description
    ): ProxyBindingEntity {
        /**
         * @var ProxyBindingEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call(
            $this->updateProxyEmails,
            [
                'id' => $id,
                'real_addresses' => $realAddresses,
                'proxy_address' => $proxyAddress,
                'callback_url' => $callbackUrl ?? '',
                'description' => $description ?? '',
            ],
            [
                'id' => $id,
            ]
        );
        $this->mapError($r);

        return $r;
    }

    public function getReceivedEmailsLinksByProxyEmailId(string $id): ReceivedEmailLinksEntityCollection
    {
        /**
         * @var ReceivedEmailLinksEntityCollection|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call(
            $this->getReceivedEmailsLinks,
            [],
            [
                'id' => $id,
            ]);
        $this->mapError($r);

        return $r;
    }

    public function getReceivedEmailDetailsByReceivedEmailId(string $id): ReceivedEmailDetailsEntity
    {
        /**
         * @var ReceivedEmailDetailsEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call(
            $this->getReceivedEmailsDetails,
            [],
            [
                'id' => $id,
            ]);
        $this->mapError($r);

        return $r;
    }

    /**
     * Please note that it's created for testing purposes
     * Do not use as it shouldn't work for you
     * If you need email sending functionality please contact us
     * @param string $name
     * @param string $to
     * @param string $message
     * @return NullableEntity
     * @throws FacadeApiErrorException
     * @throws GuzzleException
     */
    public function internalSendMail(
        string $name,
        string $to,
        string $message
    ): NullableEntity
    {
        /**
         * @var NullableEntity|ErrorResponseEntity $r
         */
        $r = $this->endpointService->call(
            $this->sendMessageInternalEndpoint,
            [],
            [
                'name' => $name,
                'to' => $to,
                'message' => $message,
            ]);
        $this->mapError($r);

        return $r;
    }

    public function generateInternalEmail(): string
    {
        return md5(uniqid() . time()) . '@proxiedmail-int.int';
    }

    /**
     * @param ResponseEntityInterface $r
     * @throws FacadeApiErrorException
     */
    private function mapError(ResponseEntityInterface $r): void
    {
        if ($r instanceof ErrorResponseEntity) {
            throw new FacadeApiErrorException($r->getMessage());
        }
    }
}

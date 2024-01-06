<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Facades;

use GuzzleHttp\Exception\GuzzleException;
use ProxiedMail\Client\Entities\Endpoints\AuthEndpoint;
use ProxiedMail\Client\Entities\Endpoints\CreateProxyEmailEndpoint;
use ProxiedMail\Client\Entities\Endpoints\CreateWebhookReceiverEndpoint;
use ProxiedMail\Client\Entities\Endpoints\GetApiTokenEndpoint;
use ProxiedMail\Client\Entities\Endpoints\GetProxyEmailsEndpoint;
use ProxiedMail\Client\Entities\Endpoints\GetWebhookStatusEndpoint;
use ProxiedMail\Client\Entities\Endpoints\UpdateProxyEmailsEndpoint;
use ProxiedMail\Client\Entities\ResponseEntity\ApiTokenEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ErrorResponseEntity;
use ProxiedMail\Client\Entities\ResponseEntity\OauthAccessTokenEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ProxyBindingsCollectionEntity;
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

    public function __construct(
        EndpointService $endpointService,
        GetProxyEmailsEndpoint $getProxyEmailsEndpoint,
        GetWebhookStatusEndpoint $getWebhookStatusEndpoint,
        CreateWebhookReceiverEndpoint $createWebhookReceiverEndpoint,
        GetApiTokenEndpoint $getApiTokenEndpoint,
        AuthEndpoint $authEndpoint,
        CreateProxyEmailEndpoint $createProxyEmailEndpoint,
        UpdateProxyEmailsEndpoint $updateProxyEmails
    ) {
        $this->endpointService = $endpointService;
        $this->getProxyEmailsEndpoint = $getProxyEmailsEndpoint;
        $this->getWebhookStatusEndpoint = $getWebhookStatusEndpoint;
        $this->createWebhookReceiverEndpoint = $createWebhookReceiverEndpoint;
        $this->getApiTokenEndpoint = $getApiTokenEndpoint;
        $this->auth = $authEndpoint;
        $this->createProxyEmailEndpoint = $createProxyEmailEndpoint;
        $this->updateProxyEmails = $updateProxyEmails;
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
        array $realAddresses,
        string $proxyAddress,
        ?string $callbackUrl,
        ?string $description
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

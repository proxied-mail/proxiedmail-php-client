<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Entities\Endpoints;

use ProxiedMail\Client\Transformers\ResponseMappers\MapperInterface;
use ProxiedMail\Client\Transformers\ResponseMappers\ReceivedEmailsDetailsResponseMapper;
use ProxiedMail\Client\Transformers\ResponseMappers\ReceivedEmailsLinksResponseMapper;

class GetReceivedEmailsDetails implements EndpointInterface
{
    private ReceivedEmailsDetailsResponseMapper $receivedEmailsDetailsResponseMapper;

    public function __construct(ReceivedEmailsDetailsResponseMapper $receivedEmailsDetailsResponseMapper)
    {
        $this->receivedEmailsDetailsResponseMapper = $receivedEmailsDetailsResponseMapper;
    }

    public function getMethod(): string
    {
        return self::METHOD_GET;
    }

    public function getUrl(array $urlParams = []): string
    {
        return self::API_V1 . 'received-emails/' . $urlParams['id'];
    }

    public function getPayload(array $arguments = []): array
    {
        return [];
    }

    public function getMapper(): MapperInterface
    {
        return $this->receivedEmailsDetailsResponseMapper;
    }
}

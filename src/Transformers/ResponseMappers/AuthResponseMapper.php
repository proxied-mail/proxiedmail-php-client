<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Transformers\ResponseMappers;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Entities\ResponseEntity\OauthAccessTokenEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ResponseEntityInterface;
use ProxiedMail\Client\Exceptions\InvalidApiResponseException;

class AuthResponseMapper implements MapperInterface
{
    /**
     * @throws InvalidApiResponseException
     */
    public function map(ResponseInterface $response): ResponseEntityInterface
    {
        $json = $response->getResponseJson();

        if (empty($json['data']['attributes']['token'])) {
            throw new InvalidApiResponseException('Invalid response');
        }

        return new OauthAccessTokenEntity($json['data']['attributes']['token']);
    }
}

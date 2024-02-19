<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Http;

use ProxiedMail\Client\Entities\Client\ResponseInterface;
use ProxiedMail\Client\Exceptions\InvalidApiResponseException;

class ResponseValidator
{
    /**
     * @param ResponseInterface $response
     * @throws InvalidApiResponseException
     */
    public function validate(ResponseInterface $response): void
    {
        $json = $response->getResponseJson();

        if (!empty($json['status']) && ($json['status'] === 'ok' || $json['status'] === 'success')) {
            return ;
        }

        if (!empty($json['token'])) {
            return ;
        }

        if (!isset($json['data'])) {
            throw new InvalidApiResponseException(
                "Invalid response. No data found. Response: \n" . json_encode($json, JSON_PRETTY_PRINT)
            );
        }
    }
}

<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Services;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use ProxiedMail\Client\Entities\Client\Request;
use ProxiedMail\Client\Config\Config;
use ProxiedMail\Client\Entities\Endpoints\EndpointInterface;
use ProxiedMail\Client\Entities\ResponseEntity\ErrorResponseEntity;
use ProxiedMail\Client\Entities\ResponseEntity\ResponseEntityInterface;
use ProxiedMail\Client\Exceptions\InvalidApiResponseException;
use ProxiedMail\Client\Exceptions\ServerErrorApiResponseException;
use ProxiedMail\Client\Http\RequestExecutor;
use ProxiedMail\Client\Http\ResponseValidator;

class EndpointService
{
    private RequestExecutor $requestExecutor;

    private ResponseValidator $responseValidator;

    private Config $config;

    public function __construct(
        RequestExecutor $requestExecutor,
        ResponseValidator $responseValidator,
        Config $config
    ) {
        $this->requestExecutor = $requestExecutor;
        $this->responseValidator = $responseValidator;
        $this->config = $config;
    }

    /**
     * @throws GuzzleException
     */
    public function call(
        EndpointInterface $endpoint,
        array $arguments = [],
        array $urlParams = []
    ): ResponseEntityInterface {
        $payload = $endpoint->getPayload($arguments);

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if (!empty($this->config->getApiToken())) {
            $headers['Token'] = $this->config->getApiToken();
        }

        if (!empty($this->config->getBearerToken())) {
            $headers['Authorization'] = $this->config->getBearerToken();
        }

        try {
            $response = $this->requestExecutor->execute(new Request(
                $endpoint->getMethod(),
                $this->config->getHost() . $endpoint->getUrl($urlParams),
                $payload,
                $headers,
            ));
        } catch (ClientException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            $json = json_decode($response, true);
            $def = 'Check out code for more details. Code: 2221 (search by code to put var dump)';
            $msg = $json['data']['attributes']['message'] ?? $def;
            throw new InvalidApiResponseException($msg);
        } catch (ServerException $serverException) {
            $response = $serverException->getResponse()->getBody()->getContents();
            $json = json_decode($response, true);
            $def = 'Check out code for more details. Code: 2229 (search by code to put var dump)';
            $msg = $json['data']['attributes']['message'] ?? $def;
            throw new ServerErrorApiResponseException($msg);
        }



        $this->responseValidator->validate($response);

        $rspArr = $response->getResponseJson();
        if (($rspArr['data']['type'] ?? null) === ErrorResponseEntity::TYPE) {
            return new ErrorResponseEntity($rspArr['data']['attributes']['message'] ?? 'Unknown error');
        }

        return $endpoint->getMapper()->map($response);
    }
}

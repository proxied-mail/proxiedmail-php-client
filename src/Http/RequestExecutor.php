<?php
declare(strict_types=1);

namespace ProxiedMail\Client\Http;

use ProxiedMail\Client\Entities\Client\RequestInterface;
use ProxiedMail\Client\Entities\Client\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use ProxiedMail\Client\Entities\Client\Response;

class RequestExecutor
{
    /**
     * @var Client
     */
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function execute(RequestInterface $request): ResponseInterface
    {
        $request = $this->client->request($request->getMethod(), $request->getUrl(), [
            RequestOptions::HEADERS => $request->getHeaders(),
            RequestOptions::JSON => $request->getPayload(),
        ]);

        $jsonResponse = json_decode($request->getBody()->getContents(), true);

        return new Response($jsonResponse);
    }
}

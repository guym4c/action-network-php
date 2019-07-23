<?php

namespace Guym4c\ActionNetwork\Request;

use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\Client;
use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;
use Stiphle\Throttle;
use Teapot\StatusCode;

class Request {

    const THROTTLER_ID = 'action_network';

    /**
     * @var Client
     */
    protected $actionNetwork;

    /** @var GuzzleHttp\Client */
    private $http;

    /** @var Throttle\LeakyBucket */
    private $throttler;

    /** @var Psr7\Request */
    private $request;

    /** @var array */
    private $options = [];

    public function __construct(Client $actionNetwork, string $uri, string $method = 'GET') {

        $this->actionNetwork = $actionNetwork;
        $this->http = new GuzzleHttp\Client();
        $this->throttler = new Throttle\LeakyBucket();

        $this->request = new Psr7\Request($method, $uri, ['OSDI-API-Token' => $this->actionNetwork->getToken()]);
    }

    /**
     * @return array
     * @throws ActionNetworkApiException
     */
    public function execute(): array {

        usleep($this->getRateLimitWaitTime() * 1000);

        try {
            $response = $this->http->send($this->request, $this->options);
        } catch (GuzzleException $e) {
            throw ActionNetworkApiException::fromGuzzle($e);
        }

        $responseBody = (string)$response->getBody();
        $responseCode = $response->getStatusCode();

        if ($responseCode !== StatusCode::OK) {
            throw ActionNetworkApiException::fromErrorResponse($responseCode, $responseBody);
        }

        return json_decode($responseBody, true);
    }

    private function getRateLimitWaitTime(): int {
        return $this->throttler->throttle(self::THROTTLER_ID, 4, 1000);
    }

}
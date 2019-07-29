<?php

namespace Guym4c\ActionNetwork;

use Exception;
use Guym4c\ActionNetwork\Entity\EntryPoint;
use Guym4c\ActionNetwork\Entity\Utils\WebhookEvent;
use Guym4c\ActionNetwork\Request\Request;
use Psr\Http\Message\RequestInterface;

class Client {

    private const API_ENTRY_POINT = 'https://actionnetwork.org/api/v2';

    private $token;

    private $entryPoint;

    /**
     * Client constructor.
     * @param string $token
     * @throws ActionNetworkApiException
     * @throws Exception
     */
    public function __construct(string $token) {
        $this->token = $token;
        $this->entryPoint = new EntryPoint($this, (new Request($this, self::API_ENTRY_POINT))->execute());
    }

    /**
     * @param RequestInterface $request
     * @return WebhookEvent[]
     */
    public function handleWebhook(RequestInterface $request): array {

        $requestBody = (string)$request->getBody();
        $events = [];
        foreach (json_decode($requestBody, true) as $event) {
            $event[] = new WebhookEvent($this, $event);
        }
        return $events;
    }

    /**
     * @return string
     */
    public function getToken(): string {
        return $this->token;
    }

    /**
     * @return EntryPoint
     */
    public function api(): EntryPoint {
        return $this->entryPoint;
    }
}
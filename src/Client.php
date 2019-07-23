<?php

namespace Guym4c\ActionNetwork;

use Guym4c\ActionNetwork\Entity\EntryPoint;
use Guym4c\ActionNetwork\Request\Request;

class Client {

    const API_ENTRY_POINT = 'https://actionnetwork.org/api/v2';

    private $token;

    private $entryPoint;

    /**
     * Client constructor.
     * @param string $token
     * @throws ActionNetworkApiException
     */
    public function __construct(string $token) {
        $this->token = $token;
        $this->entryPoint = new EntryPoint($this, (new Request($this, self::API_ENTRY_POINT))->execute());
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
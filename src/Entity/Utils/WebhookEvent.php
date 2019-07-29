<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\Client;
use Guym4c\ActionNetwork\Entity\AbstractHalEntity;
use Guym4c\ActionNetwork\Entity\Link;
use Guym4c\ActionNetwork\Entity\Person;

class WebhookEvent {

    /** @var string */
    private $resource;

    /** @var array */
    private $json;

    /** @var Link\ToParent */
    private $link;

    private const ENTITY_FILTER_KEYS = ['action_network:sponsor'];

    private const OSDI_TYPE_TO_RESOURCE_DICTIONARY = [
        'osdi:people' => Person::class,
    ];

    public function __construct(Client $actionNetwork, array $json) {
        $key = array_diff(array_keys($json), self::ENTITY_FILTER_KEYS)[0];
        $this->json = $json[$key];
        $this->resource = self::OSDI_TYPE_TO_RESOURCE_DICTIONARY[$key];
        $this->link = new Link\ToParent($actionNetwork, $this->json[$key]['_link']['self']['href'], $this->resource);
    }

    /**
     * @return AbstractHalEntity
     * @throws ActionNetworkApiException
     */
    public function loadEntity(): AbstractHalEntity {
        return $this->link->load();
    }

    /**
     * @return string
     */
    public function getResourceType(): string {
        return $this->resource;
    }

    /**
     * @return array
     */
    public function getJson(): array {
        return $this->json;
    }
}
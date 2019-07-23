<?php

namespace Guym4c\ActionNetwork;

use Guym4c\ActionNetwork\Request\HalCollectionRequest;

class HalCollection {

    /** @var Client */
    private $actionNetwork;

    /** @var int */
    private $pageNumber;

    /** @var string */
    private $next;

    /** @var string */
    private $resource;

    /** @var array */
    private $resources;

    public function __construct(Client $actionNetwork, array $json, string $class) {
        $this->actionNetwork = $actionNetwork;
        $this->pageNumber = $json['page'];
        $this->next = $json['_links']['next'];
        $this->resource = $class;

        /** @noinspection PhpUndefinedMethodInspection */
        foreach ($json['_embedded'][$class::getLinkName()] as $resource) {
            $this->resources[] = new $class($this->actionNetwork, $resource);
        }
    }

    /**
     * @return HalCollection
     * @throws ActionNetworkApiException
     */
    public function next(): HalCollection {
        return (new HalCollectionRequest($this->actionNetwork, $this->next))
            ->getResponse($this->resource);
    }


}
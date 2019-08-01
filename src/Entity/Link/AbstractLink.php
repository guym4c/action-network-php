<?php

namespace Guym4c\ActionNetwork\Entity\Link;

use Guym4c\ActionNetwork\Client;

abstract class AbstractLink {

    /** @var Client */
    protected $actionNetwork;

    /** @var string */
    protected $href;

    /** @var string */
    protected $resource;

    /**
     * LinkToParent constructor.
     * @param Client $actionNetwork
     * @param string $href
     * @param string $resource
     */
    public function __construct(Client $actionNetwork, string $resource, $links) {
        $this->actionNetwork = $actionNetwork;

        if (is_array($links)) {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->href = $links[$resource::getLinkName()];
        } else {
            $this->href = $links;
        }
        $this->resource = $resource;
    }

    abstract public function load();
}
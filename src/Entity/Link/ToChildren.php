<?php

namespace Guym4c\ActionNetwork\Entity\Link;

use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\HalCollection;
use Guym4c\ActionNetwork\Request\HalCollectionRequest;

class ToChildren extends AbstractLink {

    /**
     * @return HalCollection
     * @throws ActionNetworkApiException
     */
    public function load(): HalCollection {
        return (new HalCollectionRequest($this->actionNetwork, $this->href))
            ->getResponse($this->resource);
    }
}
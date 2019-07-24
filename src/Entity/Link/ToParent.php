<?php

namespace Guym4c\ActionNetwork\Entity\Link;

use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\Entity\AbstractHalEntity;
use Guym4c\ActionNetwork\Request\HalEntityRequest;

class ToParent extends AbstractLink {

    /**
     * @return AbstractHalEntity
     * @throws ActionNetworkApiException
     */
    public function load(): AbstractHalEntity {
        return (new HalEntityRequest($this->actionNetwork, $this->href))
            ->getResponse($this->resource);
    }
}
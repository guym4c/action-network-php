<?php

namespace Guym4c\ActionNetwork\Entity;

use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\HalCollection;

class EntryPoint extends AbstractHalEntity {

    /**
     * @return HalCollection
     * @throws ActionNetworkApiException
     */
    public function people(): HalCollection {
        return $this->getLinkedCollection(Person::class);
    }
}
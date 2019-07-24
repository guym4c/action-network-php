<?php

namespace Guym4c\ActionNetwork\Request;

use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\Entity\AbstractHalEntity;

class HalEntityRequest extends Request {

    /**
     * @param string $class
     * @return AbstractHalEntity
     * @throws ActionNetworkApiException
     */
    public function getResponse(string $class): AbstractHalEntity {

        return new $class($this->execute());
    }

}
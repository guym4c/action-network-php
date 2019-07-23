<?php

namespace Guym4c\ActionNetwork\Request;

use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\HalCollection;

class HalCollectionRequest extends Request {

    /**
     * @param string $class
     * @return HalCollection
     * @throws ActionNetworkApiException
     */
    public function getResponse(string $class): HalCollection {

        return new HalCollection($this->actionNetwork, $this->execute(), $class);
    }

}
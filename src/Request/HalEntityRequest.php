<?php

namespace Guym4c\ActionNetwork\Request;

use Guym4c\ActionNetwork\ActionNetworkApiException;

class HalEntityRequest extends Request {

    /**
     * @param string $class
     * @return object
     * @throws ActionNetworkApiException
     */
    public function getResponse(string $class): object {

        return new $class($this->execute());
    }

}
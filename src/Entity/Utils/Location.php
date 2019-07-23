<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use Guym4c\ActionNetwork\Entity\AbstractModel;

class Location extends AbstractModel {

    /** @var float */
    public $latitude;

    /** @var float */
    public $longitude;

    /**
     * @var string
     * @see LocationAccuracy
     */
    public $accuracy;

    public function __construct(array $json) {
        $this->hydrate($json);
    }

}
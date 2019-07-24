<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use Guym4c\ActionNetwork\Entity\AbstractModel;

class Referrer extends AbstractModel {

    /** @var string */
    public $source;

    /** @var string */
    public $referrer;

    /** @var string */
    public $website;

    public function __construct(array $json) {
        $this->hydrate($json);
    }
}
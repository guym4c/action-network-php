<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use Guym4c\ActionNetwork\Entity\AbstractModel;

class Sponsor extends AbstractModel {

    /** @var string */
    public $title;

    /** @var string */
    public $browserUrl;

    public function __construct(array $json) {
        $this->hydrate($json);
    }
}
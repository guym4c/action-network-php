<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use Guym4c\ActionNetwork\Entity\AbstractModel;

class EmailAddress extends AbstractModel {

    /** @var bool */
    public $primary;

    /** @var string */
    public $address;

    /**
     * @var string
     * @see SubscriptionStatus
     */
    public $status;

    public function __construct(array $json) {
        $this->hydrate($json);
    }
}
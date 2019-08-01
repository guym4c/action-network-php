<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

use Guym4c\ActionNetwork\Entity\AbstractModel;

class AbstractAddress extends AbstractModel {

    /** @var string[] */
    public $addressLines;

    /** @var string */
    public $locality;

    /** @var string */
    public $region;

    /** @var string */
    public $postalCode;

    /** @var string */
    public $country;

    /** @var string */
    public $language;

    /** @var Location */
    public $location;

    public function __construct(array $json) {
        $this->hydrate($json);
    }

    public function jsonSerialize(): array {
        return $this->serialize([
            'location' => $this->location->jsonSerialize(),
        ]);
    }

}
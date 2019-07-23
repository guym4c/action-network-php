<?php

namespace Guym4c\ActionNetwork\Entity\Utils;

class Identifier {

    /** @var string */
    public $name;

    /** @var string */
    public $id;

    public function __construct(string $s) {
        list($this->name, $this->id) = explode(":", $s);
    }
}
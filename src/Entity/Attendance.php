<?php

namespace Guym4c\ActionNetwork\Entity;

use Guym4c\ActionNetwork\Client;
use Guym4c\ActionNetwork\Entity\Utils\AttendanceStatus;
use Guym4c\ActionNetwork\Entity\Utils\Referrer;

class Attendance extends AbstractHalEntity {

    public static $linkName = 'osdi:attendances';

    /**
     * @var string
     * @see AttendanceStatus
     */
    public $status;

    /** @var Link\ToParent */
    public $person;

    /** @var string */
    //TODO
    public $event;

    /** @var Referrer */
    public $referrer;

    public function __construct(Client $actionNetwork, array $json) {
        parent::__construct($actionNetwork, $json);

        $this->referrer = new Referrer($json['action_network:referrer_data']);
        $this->person = new Link\ToParent($this->actionNetwork, $this->links['osdi:person'], Person::class);
        $this->event = $json['action_network:event_id'];
        $this->hydrate($json);
    }
}
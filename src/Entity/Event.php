<?php

namespace Guym4c\ActionNetwork\Entity;

use DateTime;
use Guym4c\ActionNetwork\Client;
use Guym4c\ActionNetwork\Entity\Utils\EventLocation;
use Guym4c\ActionNetwork\Entity\Utils\EventStatus;
use Guym4c\ActionNetwork\Entity\Utils\Sponsor;
use Guym4c\ActionNetwork\Entity\Utils\Transparency;
use Guym4c\ActionNetwork\Entity\Utils\Visibility;

class Event extends AbstractHalEntity {

    public static $linkName = 'osdi:events';

    /** @var string */
    public $originSystem;

    /** @var string */
    public $name;

    /** @var string */
    public $title;

    /** @var string */
    public $description;

    /** @var string */
    public $instructions;

    /** @var string */
    public $browserUrl;

    /** @var string */
    public $featuredImageUrl;

    /** @var DateTime */
    public $startDate;

    /** @var EventLocation */
    public $location;

    /** @var int */
    public $totalAccepted;

    //TODO
    /** @var string */
    public $eventCampaign;

    /**
     * @var string
     * @see EventStatus
     */
    public $status;

    /**
     * @var string
     * @see Transparency
     */
    public $transparence;

    /**
     * @var string
     * @see Visibility
     */
    public $visibility;

    /** @var bool */
    public $guestsCanInviteOthers;

    /** @var int */
    public $capacity;

    /** @var bool */
    public $hidden;

    //TODO
    /** @var array */
    public $reminders;

    /** @var Sponsor */
    public $sponsor;

    public function __construct(Client $actionNetwork, array $json) {
        parent::__construct($actionNetwork, $json);

        $this->startDate = new DateTime($json['start_date']);
        $this->location = new EventLocation($json['location']);
        $this->sponsor = new Sponsor($json['sponsor']);
    }

    public function jsonSerialize(): array {
        return $this->serialize([
            'start_date' => $this->startDate->format(DATE_ATOM),
            'location'   => $this->location->jsonSerialize(),
            'sponsor'    => $this->sponsor->jsonSerialize(),
        ]);
    }

}
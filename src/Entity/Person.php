<?php

namespace Guym4c\ActionNetwork\Entity;

use Exception;
use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\Client;
use Guym4c\ActionNetwork\Entity\Utils\EmailAddress;
use Guym4c\ActionNetwork\Entity\Utils\PostalAddress;

class Person extends AbstractHalEntity {

    public static $linkName = 'osdi:people';

    /** @var array */
    public $identifiers;

    /** @var string */
    public $familyName;

    /** @var string */
    public $givenName;

    /** @var string[] */
    public $languagesSpoken;

    /** @var EmailAddress[] */
    public $emailAddresses;

    /** @var $postalAddresses[] */
    public $postalAddresses;

    /** @var Link\ToChildren */
    public $attendances;

    /**
     * Person constructor.
     * @param Client $actionNetwork
     * @param array  $json
     * @throws Exception
     */
    public function __construct(Client $actionNetwork, array $json) {
        parent::__construct($actionNetwork, $json);

        $this->populateArrayType(EmailAddress::class, 'emailAddresses', $json);
        $this->populateArrayType(PostalAddress::class, 'postalAddresses', $json);
        $this->attendances = new Link\ToChildren($this->actionNetwork, $this->links['osdi:attendances'], Attendance::class);

        $this->hydrate($json);
    }

    public function jsonSerialize(): array {
        return $this->serialize([
            'email_addresses' => self::serializeArray($this->emailAddresses),
            'postal_addresses' => self::serializeArray($this->postalAddresses),
        ]);
    }

    /**
     * Allow PUT requests
     *
     * @return object
     * @throws ActionNetworkApiException
     */
    public function persist(): object {
        return parent::persist();
    }


}
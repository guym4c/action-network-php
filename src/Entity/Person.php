<?php

namespace Guym4c\ActionNetwork\Entity;

use DateTime;
use Exception;
use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\Client;
use Guym4c\ActionNetwork\Entity\Utils\EmailAddress;
use Guym4c\ActionNetwork\Entity\Utils\PostalAddress;
use Guym4c\ActionNetwork\HalCollection;

class Person extends AbstractHalEntity {

    public static $linkName = 'osdi:people';

    /** @var array */
    public $identifiers;

    /** @var DateTime */
    public $created;

    /** @var DateTime */
    public $modified;

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

    /**
     * Person constructor.
     * @param Client $actionNetwork
     * @param array  $json
     * @throws Exception
     */
    public function __construct(Client $actionNetwork, array $json) {
        parent::__construct($actionNetwork, $json);

        $this->created = new DateTime($json['created_date']);
        $this->modified = new DateTime($json['modified_date']);
        $this->populateArrayType(EmailAddress::class, 'emailAddresses', $json);
        $this->populateArrayType(PostalAddress::class, 'postalAddresses', $json);

        $this->hydrate($json);
    }

    public function jsonSerialize(): array {
        return $this->serialize([
            'created_date' => $this->created->format(DATE_ATOM),
            'modified_date' => $this->modified->format(DATE_ATOM),
            'email_addresses' => self::serializeArray($this->emailAddresses),
            'postal_addresses' => self::serializeArray($this->postalAddresses),
        ]);
    }

    /**
     * @return HalCollection
     * @throws ActionNetworkApiException
     */
    public function attendances(): HalCollection {
        return $this->getLinkedCollection(Attendance::class);
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
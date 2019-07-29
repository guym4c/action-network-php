<?php

namespace Guym4c\ActionNetwork\Entity;

use DateTime;
use Exception;
use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\Client;
use Guym4c\ActionNetwork\HalCollection;
use Guym4c\ActionNetwork\Request\HalCollectionRequest;
use Guym4c\ActionNetwork\Request\HalEntityRequest;

abstract class AbstractHalEntity extends AbstractModel {

    private const LINK_FILTER_KEYS = ['docs', 'self', 'canvasser:brand_logo', 'curies'];

    /** @var Client */
    protected $actionNetwork;

    /** @var string */
    protected $uri;

    /** @var string */
    public static $linkName = '';

    /** @var array */
    protected $links;

    /** @var array */
    public $identifiers;

    /** @var DateTime */
    public $created;

    /** @var DateTime */
    public $modified;

    /** @var array */
    public $custom;

    public static function getLinkName(): string {
        return static::$linkName;
    }

    /**
     * AbstractHalEntity constructor.
     * @param Client $actionNetwork
     * @param array  $json
     * @throws Exception
     */
    public function __construct(Client $actionNetwork, array $json) {

        $this->actionNetwork = $actionNetwork;
        $this->uri = $json['_links']['self']['href'];
        $this->identifiers = self::parseIdentifiers($json['identifiers']);
        $this->created = new DateTime($json['created_date']);
        $this->modified = new DateTime($json['modified_date']);
        $this->custom = $json['custom_fields'] ?? [];

        foreach ($json['_links'] as $linkName => $link) {

            if (!in_array($linkName, self::LINK_FILTER_KEYS)) {
                $this->links[$linkName] = $link['href'];
            }
        }
    }

    /**
     * @param string $class
     * @return HalCollection
     * @throws ActionNetworkApiException
     */
    protected function getLinkedCollection(string $class): HalCollection {

        /** @noinspection PhpUndefinedMethodInspection */
        return (new HalCollectionRequest($this->actionNetwork, $this->links[$class::getLinkName()]))
            ->getResponse($class);
    }

    protected static function parseIdentifiers(array $identifiers): array {
        $result = [];
        foreach ($identifiers as $identifier) {
            list($key, $value) = explode(':', $identifier);
            $result[$key] = $value;
        }
        return $result;
    }

    protected function serializeIdentifiers(): array {
        $result = [];
        foreach ($this->identifiers as $name => $identifier) {
            $result[] = "$name:$identifier";
        }
        return $result;
    }

    protected function serialize(array $data = []): array {
        return parent::serialize([
            'identifiers' => $this->serializeIdentifiers(),
            'created_date' => $this->created->format(DATE_ATOM),
            'modified_date' => $this->modified->format(DATE_ATOM),
        ]);
    }

    /**
     * @return object
     * @throws ActionNetworkApiException
     */
    protected function persist(): object {
        return (new HalEntityRequest($this->actionNetwork, $this->uri, 'PUT'))
            ->getResponse(static::class);
    }

    /**
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getLinks() {
        return $this->links;
    }
}
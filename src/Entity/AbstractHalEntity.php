<?php

namespace Guym4c\ActionNetwork\Entity;

use Guym4c\ActionNetwork\ActionNetworkApiException;
use Guym4c\ActionNetwork\Client;
use Guym4c\ActionNetwork\HalCollection;
use Guym4c\ActionNetwork\Request\HalCollectionRequest;

abstract class AbstractHalEntity extends AbstractModel {

    const LINK_FILTER_KEYS = ['docs', 'self', 'canvasser:brand_logo', 'curies'];

    /** @var Client */
    protected $actionNetwork;

    /** @var string */
    protected $uri;

    /** @var string */
    public static $linkName = '';

    /** @var array */
    protected $links;

    /** @var array */
    public $custom;

    public static function getLinkName(): string {
        return static::$linkName;
    }

    public function __construct(Client $actionNetwork, array $json) {

        $this->actionNetwork = $actionNetwork;
        $this->uri = $json['_links']['self']['href'];

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
<?php

namespace Guym4c\ActionNetwork\Entity;

use JsonSerializable;

abstract class AbstractModel implements JsonSerializable {

    protected function propertyNameToJson(string $property) {
        return strtolower(
            preg_replace('/([A-Z])/', '_$1', $property));
    }

    protected function hydrate(array $json): void {
        foreach (get_object_vars($this) as $property => $value) {
            if (empty($value)) {
                $this->{$property} = $json[$this->propertyNameToJson($property)] ?? null;
            }
        }
    }

    protected function populateArrayType(string $class, string $key, array $json): void {

        foreach ($json[$this->propertyNameToJson($key)] as $value) {
            $this->{$key}[] = new $class($value);
        }
    }

    public function jsonSerialize(): array {
        return $this->serialize();
    }

    protected function serialize(array $data = []): array {

        foreach (get_object_vars($this) as $property => $value) {
            $jsonKey = $this->propertyNameToJson($property);
            if (empty($data[$jsonKey])) {
                $data[$jsonKey] = $value;
            }
        }
        return $data;
    }

    protected static function serializeArray(array $models): array {
        $result = [];

        /** @var $models AbstractModel[] */
        foreach ($models as $model) {
            $result[] = $model->jsonSerialize();
        }
        return $result;
    }
}
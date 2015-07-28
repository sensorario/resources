<?php

namespace Sensorario\ValueObject;

use RuntimeException;

abstract class ValueObject
{
    protected $properties = [];

    public function __call($functionName, $arguments)
    {
        return $this->properties[
            $key = strtolower($functionName)
        ];
    }

    protected function __construct(array $properties)
    {
        $this->properties = $properties;

        $this->ensureMandatoryProperties();
        $this->ensureAllowedProperties();
    }

    protected function ensureMandatoryProperties()
    {
        foreach ($this->mandatory() as $key) {
            if (!isset($this->properties[$key])) {
                throw new RuntimeException(
                    "Property $key is mandatory but not set"
                );
            }
        }
    }

    protected function ensureAllowedProperties()
    {
        $allowed = array_merge(
            $this->allowed(),
            $this->mandatory()
        );

        foreach ($this->properties as $key => $property) {
            if (!in_array($key, $allowed)) {
                throw new RuntimeException(
                    "Key $key is not allowed"
                );
            }
        }
    }

    public static function box(array $properties)
    {
        return new static(
            $properties
        );
    }

    protected static function mandatory()
    {
        return [];
    }

    protected static function allowed()
    {
        return [];
    }
}

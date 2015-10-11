<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject;

use RuntimeException;

abstract class ValueObject
{
    private $properties = [];

    public function __call($functionName, $arguments)
    {
        $propertyName = strtolower($functionName);

        if ($this->hasProperty($propertyName)) {
            return $this->get($propertyName);
        }

        if (isset($this->defaults()[$propertyName])) {
            return $this->defaults()[$propertyName];
        }

        throw new RuntimeException(
            'Method `' . get_class($this)
            . '::' . $functionName 
            . '()` is not yet implemented'
        );
    }

    protected function __construct(array $properties)
    {
        $this->properties = $properties;

        $this->ensureRightType();
        $this->ensureMandatoryProperties();
        $this->ensureAllowedProperties();
        $this->ensureAllowedValues();
    }

    protected function ensureRightType()
    {
        foreach ($this->properties() as $key => $value) {
            if (isset(static::types()[$key])) {
                $type = static::types()[$key];

                if (!is_object($this->get($key))) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be an object'
                    );
                }

                if (get_class($this->get($key)) != $type) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be an object of type ' . $type
                    );
                }
            }
        }
    }

    protected function ensureMandatoryProperties()
    {
        foreach ($this->mandatory() as $key => $value) {
            if (is_numeric($key) && $this->hasNotProperty($value)) {
                if (!isset(static::defaults()[$value])) {
                    throw new RuntimeException(
                        "Property `" . get_class($this)
                        . "::\$$value` is mandatory but not set"
                    );
                }
            }

            if (!is_numeric($key) && $this->hasProperty($value['if_present'])) {
                if ($this->hasNotProperty($key)) {
                    throw new RuntimeException(
                        "Property `" . get_class($this)
                        . "::\${$key}` is mandatory but not set"
                    );
                }
            }
        }
    }

    protected function ensureAllowedProperties()
    {
        $allowed = array_merge(
            $this->allowed(),
            $this->mandatory()
        );

        foreach ($this->properties() as $key => $property) {
            if (!in_array($key, $allowed)) {
                throw new RuntimeException(
                    "Key `" . get_class($this)
                    . "::\$$key` is not allowed"
                );
            }
        }
    }

    protected function ensureAllowedValues()
    {
        foreach ($this->properties() as $key => $value) {
            if (isset($this->allowedValues()[$key])) {
                if (!in_array($value, $this->allowedValues()[$key])) {
                    throw new RuntimeException(
                        'Value `' . $value . '` is not allowed '
                        . 'for key `' . $key . '`'
                    );
                }
            }
        }
    }

    public static function __callStatic($methodName, array $args)
    {
        $methodWhiteList = [
            'box',
            'allowedValues'
        ];

        $isMethodNameWhiteListed = in_array(
            $methodName,
            $methodWhiteList
        );

        if ($isMethodNameWhiteListed) {
            return new static(
                isset($args[0])
                ? $args[0]
                : []
            );
        }

        throw new RuntimeException(
            'Invalid factory method'
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

    protected static function allowedValues()
    {
        return [];
    }

    protected static function types()
    {
        return [];
    }

    protected static function defaults()
    {
        return [];
    }

    final public function hasProperty($propertyName)
    {
        return isset(
            $this->properties[$propertyName]
        );
    }

    final public function hasNotProperty($propertyName)
    {
        return !$this->hasProperty($propertyName);
    }

    final public function get($propertyName)
    {
        if ($this->hasNotProperty($propertyName)) {
            if (isset($this->defaults()[$propertyName])) {
                return $this->defaults()[$propertyName];
            }

            throw new RuntimeException(
                'No value nor method `'
                . $propertyName
                . '` found in this Value Object'
            );
        }

        return $this->properties[$propertyName];
    }

    final public function properties()
    {
        return $this->properties;
    }
}

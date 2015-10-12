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

        \Sensorario\Services\ValueObjectValidator::validate($this);
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
            'Invalid factory method `' . $methodName . '`'
        );
    }

    public static function mandatory()
    {
        return [];
    }

    public static function allowed()
    {
        return [];
    }

    public static function allowedValues()
    {
        return [];
    }

    public static function types()
    {
        return [];
    }

    public static function defaults()
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

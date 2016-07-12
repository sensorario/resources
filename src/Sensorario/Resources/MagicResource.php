<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources;

use RuntimeException;
use Sensorario\Resources\Validators\ResourcesValidator;

abstract class MagicResource
{
    protected $properties = [];

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

    public function __construct(
        array $properties,
        ResourcesValidator $validator,
        $validationRequired = true
    ) {
        $this->properties = $properties;

        foreach ($properties as $k => $v) {
            if ('object' === gettype($v) && !isset($this->rules()[$k])) {
                throw new RuntimeException(
                    'When property `' . $k . '` is an object class, must be defined in Resources::rules()'
                );
            }
        }

        /** @warning this convert utf8 in utf8 */
        foreach ($properties as $name => $value) {
            if ('object' !== gettype($value)) {
                $properties[$name] = utf8_encode(
                    $value
                );
            }
        }

        if ($validationRequired) {
            $validator->validate($this);
        }
    }

    public static function __callStatic($methodName, array $args)
    {
        $methodWhiteList = [
            'box',
            'allowedValues'
        ];

        $isMethodAllowed = in_array(
            $methodName,
            $methodWhiteList
        );

        if ($isMethodAllowed) {
            return new static(
                isset($args[0])
                ? $args[0]
                : [],
                new ResourcesValidator()
            );
        }

        throw new RuntimeException(
            'Invalid factory method `' . $methodName . '`'
        );
    }

    final public function hasProperty($propertyName)
    {
        return isset(
            $this->properties[$propertyName]
        );
    }

    final public function get($propertyName)
    {
        if ('' == $propertyName) {
            throw new RuntimeException(
                'Oops! Property name requested is empty string!!'
            );
        }

        if ($this->hasNotProperty($propertyName)) {
            if (isset($this->defaults()[$propertyName])) {
                return $this->defaults()[$propertyName];
            }

            throw new RuntimeException(
                'No value nor method `'
                . $propertyName
                . '` found in this resource'
            );
        }

        return $this->properties[$propertyName];
    }

    final public function hasNotProperty($propertyName)
    {
        return !$this->hasProperty($propertyName);
    }

    final public function hasProperties(array $properties)
    {
        foreach ($properties as $property) {
            if ($this->hasNotProperty($property)) {
                return false;
            }
        }

        return true;
    }

    final public function properties()
    {
        $properties = $this->properties;

        foreach ($properties as $k => $v) {
            if ('object' === gettype($v)) {
                if ($this->rules()[$k]['object'] === '\\Sensorario\\Resources\\Resource') {
                    $properties[$k] = $v->properties();
                }
            }
        }

        return $properties;
    }
}

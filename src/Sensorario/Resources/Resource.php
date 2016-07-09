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

abstract class Resource
    extends MagicResource
{
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

    public static function rules()
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

    final public function hasProperties(array $properties)
    {
        foreach ($properties as $property) {
            if ($this->hasNotProperty($property)) {
                return false;
            }
        }

        return true;
    }

    final public function hasNotProperty($propertyName)
    {
        return !$this->hasProperty($propertyName);
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

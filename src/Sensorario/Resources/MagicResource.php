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
use Sensorario\Resources\Configurator;

/**
 * @method array defaults() returns resource's default values
 * @method array rules() returns resource's rules
 */
abstract class MagicResource
{
    protected $properties = [];

    private static $methodWhiteList = [
        'box',
        'allowedValues'
    ];

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

    abstract public function applyConfiguration(Configurator $configurator);

    public function __construct(
        array $properties,
        ResourcesValidator $validator,
        Configurator $configuration = null
    ) {
        $this->properties = $properties;

        if ($configuration) {
            $this->applyConfiguration(
                $configuration
            );
        }

        foreach ($properties as $k => $v) {
            if ('object' === gettype($v) && !isset($this->rules()[$k])) {
                throw new RuntimeException(
                    'When property `' . $k . '` is an object class, must be defined in Resources::rules()'.
                    ' but rules here are equals to ' . var_export($this->rules(), true)
                    . ' And properties are ' . var_export($this->properties, true)
                );
            }
        }

        $validator->validate($this);
    }

    public static function __callStatic($methodName, array $args)
    {
        $isMethodAllowed = in_array(
            $methodName,
            self::$methodWhiteList
        );

        $configuration = null;

        if (
            isset($args[1])
            && 'Sensorario\Resources\Configurator' == get_class($args[1])
        ) {
            $configuration = new Configurator(
                $args[1]->resourceName(),
                $args[1]->container()
            );
        }

        if ($isMethodAllowed) {
            $properties = isset($args[0])
                ? $args[0]
                : [];

            return new static(
                $properties,
                new ResourcesValidator(),
                $configuration
            );
        }

        throw new RuntimeException(
            'Invalid factory method '
            . '`' . $methodName . '`'
        );
    }

    final public function hasProperty($propertyName)
    {
        return isset(
            $this->properties[$propertyName]
        );
    }

    final public function set($propertyName, $propertValue) 
    {
        $this->properties[$propertyName] = $propertValue;
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
                if (!isset($this->rules()[$k]['object'])) {
                    throw new RuntimeException(
                        'Property ' . $k . ' is an object but is not defined in rules'
                    );
                }

                if ($this->rules()[$k]['object'] === '\\Sensorario\\Resources\\Resource') {
                    $properties[$k] = $v->properties();
                }

                if ($this->rules()[$k]['object'] === 'array') {
                    $properties[$k] = (array) $v;
                }
            }
        }

        return $properties;
    }
}

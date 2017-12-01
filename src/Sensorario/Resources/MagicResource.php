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

use Sensorario\Resources\Configurator;
use Sensorario\Resources\Exceptions\FactoryMethodException;
use Sensorario\Resources\Validators\ResourcesValidator;

/**
 * @method array defaults() returns resource's default values
 * @method array rules() returns resource's rules
 */
abstract class MagicResource
{
    protected $properties = [];

    protected $validator;

    protected $configuration;

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

        throw new \Sensorario\Resources\Exceptions\UndefinedMethodException(
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
        $this->properties    = $properties;
        $this->validator     = $validator;
        $this->configuration = $configuration;

        if ($configuration) {
            $this->applyConfiguration(
                $configuration
            );
        }

        $this->init();
    }

    private function init()
    {
        $this->ensurePropertiesConsistency();
        $this->validate();
    }

    public static function __callStatic($methodName, array $args)
    {
        $isMethodAllowed = in_array($methodName, self::$methodWhiteList);
        $configuration = null;

        if (isset($args[1]) && 'Sensorario\Resources\Configurator' == get_class($args[1])) {
            $configuration = new Configurator($args[1]->resourceName(), $args[1]->container());
        }

        if ($isMethodAllowed) {
            return new static($args[0] ?? [], new ResourcesValidator(), $configuration);
        }

        throw new FactoryMethodException('Invalid factory method ' . '`' . $methodName . '`');
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
        $this->ensurePropertyNameIsNotEmpty($propertyName);

        if ($this->hasNotProperty($propertyName)) {
            if ($prop = $this->defaults()[$propertyName] ?? false) {
                return $prop;
            }

            throw new \Sensorario\Resources\Exceptions\NoValuesException(
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
                $this->ensurePropertyIsAnObjectDefined($k);

                if ($this->rules()[$k]['object'] === '\\Sensorario\\Resources\\Resource') {
                    $properties[$k] = $v->properties();
                }
            }
        }

        return $properties;
    }

    public function validate()
    {
        $this->validator->validate($this);
    }

    public function ensurePropertiesConsistency()
    {
        foreach ($this->properties as $k => $v) {
            if ('object' === gettype($v) && !isset($this->rules()[$k])) {
                throw new \Sensorario\Resources\Exceptions\PropertyWithoutRuleException(
                    'When property `' . $k . '` is an object class, must be defined in Resources::rules()' .
                    ' but rules here are equals to ' . var_export($this->rules(), true)
                    . ' And properties are ' . var_export($this->properties, true)
                );
            }
        }
    }

    public function ensurePropertyNameIsNotEmpty($propertyName)
    {
        if ('' == $propertyName) {
            throw new \Sensorario\Resources\Exceptions\PropertyNameEmptyException(
                'Oops! Property name requested is empty string!!'
            );
        }
    }

    public function ensurePropertyIsAnObjectDefined($k)
    {
        if (!isset($this->rules()[$k]['object'])) {
            throw new \Sensorario\Resources\Exceptions\PropertyWithoutRuleException(
                'Property ' . $k . ' is an object but is not defined in rules'
            );
        }
    }
}

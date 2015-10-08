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

use Sensorario\ValueObject\Exceptions\InvalidFactoryMethodException;
use Sensorario\ValueObject\Exceptions\InvalidKeyException;
use Sensorario\ValueObject\Exceptions\InvalidKeyOrValueException;
use Sensorario\ValueObject\Exceptions\InvalidMethodException;
use Sensorario\ValueObject\Exceptions\InvalidTypeException;
use Sensorario\ValueObject\Exceptions\InvalidValueException;
use Sensorario\ValueObject\Exceptions\UndefinedMandatoryPropertyException;

/**
 * A Value Object implementation in php.
 */
abstract class ValueObject
{
    /**
     * $properties array the properties of the concept whole.
     */
    private $properties = [];

    /**
     * Automatically manage getters with magic methods.
     * For each property called propertyX, is possible to call a method propertyX() tha returns that property.
     * And is possible to override this method, simply creating it: __call is called only when a REAL method does not
     * exists.
     * For non setted values, default ones are configurable
     *
     * @param string $functionName function name
     * @param array  $arguments    arguments passed to that function
     * {@example test/unit/Sensorario/ValueObject/ValueObjectTest.php 50 61}
     */
    public function __call($functionName, $arguments)
    {
        $propertyName = strtolower($functionName);

        if (isset($this->properties[$propertyName])) {
            return $this->properties[$propertyName];
        }

        if (isset($this->defaults()[$propertyName])) {
            return $this->defaults()[$propertyName];
        }

        throw new InvalidMethodException(
            'Method `' . get_class($this)
            . '::' . $functionName 
            . '()` is not yet implemented'
        );
    }

    /**
     * The constructor.
     * The keyworkd __construct does not tell to developers what this method does.
     * Enforcing developers to use a more speaking API, it could be better the creation of new instance throw public
     * static methods.
     *
     * @param array $properties all the properties of the Value Object
     */
    protected function __construct(array $properties)
    {
        $this->properties = $properties;

        /** @todo break out these responsibilities */
        $this->ensureRightType();
        $this->ensureMandatoryProperties();
        $this->ensureAllowedProperties();
        $this->ensureAllowedValues();
    }

    /**
     * Check property type
     *
     * When a property must be a specific instance of a class, an exception is thrown when is not an object or the class is different.
     *
     */
    protected function ensureRightType()
    {
        foreach ($this->properties as $key => $value) {
            if (isset(static::types()[$key])) {
                $type = static::types()[$key];

                if (!is_object($this->properties[$key])) {
                    throw new InvalidTypeException(
                        'Attribute `' . $key
                        . '` must be an object'
                    );
                }

                if (get_class($this->properties[$key]) != $type) {
                    throw new InvalidTypeException(
                        'Attribute `' . $key
                        . '` must be an object of type ' . $type
                    );
                }
            }
        }
    }

    /**
     * Mandatory properties.
     * All mandatory properties must be defined. In contrary, an exception is thrown.
     *
     * @throws Sensorario\ValueObject\Exceptions\UndefinedMandatoryPropertyException if mandatory parameter is not configured
     */
    protected function ensureMandatoryProperties()
    {
        /** @todo introduce conditional compulsory */
        foreach ($this->mandatory() as $key) {
            if (!isset($this->properties[$key])) {
                if (!isset(static::defaults()[$key])) {
                    throw new UndefinedMandatoryPropertyException(
                        "Property `" . get_class($this)
                        . "::\$$key` is mandatory but not set"
                    );
                }
            }
        }
    }

    /**
     * Allowed properties.
     * If a not allowed keyword is used, an exception is thrown.
     *
     * @throws Sensorario\ValueObject\Exceptions\InvalidKeyException if not allowed parameter is set
     */
    protected function ensureAllowedProperties()
    {
        /** @todo introduce conditional allowing of a property */
        $allowed = array_merge(
            $this->allowed(),
            $this->mandatory()
        );

        foreach ($this->properties as $key => $property) {
            if (!in_array($key, $allowed)) {
                throw new InvalidKeyException(
                    "Key `" . get_class($this)
                    . "::\$$key` is not allowed"
                );
            }
        }
    }

    /**
     * When a value not allowed is used to set a property, an exception is thrown
     */
    protected function ensureAllowedValues()
    {
        foreach ($this->properties as $key => $value) {
            if (isset($this->allowedValues()[$key])) {
                if (!in_array($value, $this->allowedValues()[$key])) {
                    throw new InvalidValueException(
                        'Value `' . $value . '` is not allowed '
                        . 'for key `' . $key. '`'
                    );
                }
            }
        }
    }

    /**
     * Static Interceptor
     *
     * @param string $methodName method name
     * @param array $args the list of properties
     *
     * @return ValueObject new ValueObject instance
     */
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

        throw new InvalidFactoryMethodException();
    }

    /**
     * Mandatory properties.
     * This method returns the array corresponding to the list of all mandatory properties.
     *
     * @return array the array of mandatory properties
     */
    protected static function mandatory()
    {
        return [];
    }

    /**
     * Allowed properties.
     * This method returns the array corresponding to the list of all allowed properties.
     *
     * @return array the array of allowed properties
     */
    protected static function allowed()
    {
        return [];
    }

    /**
     * Allowed values
     *
     * To allow only specifi value to a property
     */
    protected static function allowedValues()
    {
        return [];
    }

    /**
     * Property types
     *
     * Define all the type of property
     */
    protected static function types()
    {
        return [];
    }

    /**
     * Default values
     * Instead of writing custom factory, use default values
     *
     * @return array the array of defalt properties's value
     */
    protected static function defaults()
    {
        return [];
    }

    /**
     * Property value
     *
     * This method tells if a property with a specific name exists in current value object
     *
     * @param $propertyname the property name
     */
    final public function propertyExists($propertyName)
    {
        return isset(
            $this->properties[$propertyName]
        );
    }

    /**
     * Property value
     *
     * This method allow developer to get the value of a specific property
     *
     * @param $propertyname the property name
     */
    final public function get($propertyName)
    {
        if (!isset($this->properties[$propertyName])) {
            if (isset($this->defaults()[$propertyName])) {
                return $this->defaults()[$propertyName];
            }

            throw new InvalidKeyOrValueException(
                'No value nor method `'
                . $propertyName
                . '` found in this Value Object'
            );
        }

        return $this->properties[$propertyName];
    }

    /**
     * property type
     *
     * this method allow developer to know the type of a property
     *
     * @param $propertyname the property name
     */
    public function getPropertyType($propertyName)
    {
        if (is_object($this->properties[$propertyName])) {
            return get_class(
                $this->properties[$propertyName]
            );
        }

        return gettype(
            $this->properties[$propertyName]
        );
    }

    /**
     * Returns all the properties of current value object
     */
    public function properties()
    {
        return $this->properties;
    }
}

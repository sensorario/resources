<?php

/**
 * Value Object base class.
 * This class aims to be a base class for all kind of Value Objects.
 *
 * @author Simone Gentili
 */

/**
 * @author Simone Gentili
 */
namespace Sensorario\ValueObject;

use RuntimeException;

/**
 * A Value Object implementation in php.
 */
abstract class ValueObject
{
    /**
     * $properties array the properties of the concept whole.
     */
    protected $properties = [];

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
        $index = strtolower($functionName);

        return isset($this->properties[$index])
            ? $this->properties[$index]
            : $this->defaults()[$index]
        ;
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

        $this->ensureMandatoryProperties();
        $this->ensureAllowedProperties();
    }

    /**
     * Mandatory properties.
     * All mandatory properties must be defined. In contrary, an exception is thrown.
     *
     * @throws RuntimeException if mandatory parameter is not configured
     */
    protected function ensureMandatoryProperties()
    {
        foreach ($this->mandatory() as $key) {
            if (!isset($this->properties[$key])) {
                if (!isset(static::defaults()[$key])) {
                    throw new RuntimeException(
                        "Property $key is mandatory but not set"
                    );
                }
            }
        }
    }

    /**
     * Allowed properties.
     * If a not allowed keyword is used, an exception is thrown.
     *
     * @throws RuntimeException if not allowed parameter is set
     */
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

    /**
     * Static Interceptor
     *
     * @param string $method method name
     * @param array $args the list of properties
     *
     * @return ValueObject new ValueObject instance
     */
    public static function __callStatic($method, array $args)
    {
        return new static(
           isset($args[0])
           ? $args[0]
           : []
        );
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
     * Default values
     * Instead of writing custom factory, use default values
     *
     * @return array the array of defalt properties's value
     */
    protected static function defaults()
    {
        return [];
    }

    final public function propertyExists($propertyName)
    {
        return isset(
            $this->properties[$propertyName]
        );
    }

    final public function get($propertyName)
    {
        if (!isset($this->properties[$propertyName])) {
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
}

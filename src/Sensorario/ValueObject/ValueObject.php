<?php
/**
 * @todo complete this dock bloc comment
 * @author Simone Gentili
 */

/**
 * @todo complete this dock bloc comment
 * @author Simone Gentili
 */
namespace Sensorario\ValueObject;

use RuntimeException;

/**
 * A Value Object implementation in php.
 * @todo complete this dock bloc comment
 */
abstract class ValueObject
{
    protected $properties = [];

    /**
     * @todo complete this dock bloc comment
     * @param string $functionName function name
     * @param array  $arguments    arguments passed to that function
     * {@example test/unit/Sensorario/ValueObject/ValueObjectTest.php 50 61}
     */
    public function __call($functionName, $arguments)
    {
        return $this->properties[
            $key = strtolower($functionName)
        ];
    }

    /**
     * @todo complete this dock bloc comment
     * @param array $properties all the properties of the Value Object
     */
    protected function __construct(array $properties)
    {
        $this->properties = $properties;

        $this->ensureMandatoryProperties();
        $this->ensureAllowedProperties();
    }

    /**
     * @todo complete this dock bloc comment
     * @todo create a MissingMandatoryException class
     * @throws RuntimeException if mandatory parameter is not configured
     */
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

    /**
     * @todo complete this dock bloc comment
     * @todo create a NotallowedParameterException class
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
     * @todo complete this dock bloc comment
     * Generic constructor.
     * This method aims to generate all Value Objects.
     *
     * @return ValueObject new ValueObject instance
     */
    public static function box(array $properties)
    {
        return new static(
            $properties
        );
    }

    /**
     * @todo complete this dock bloc comment
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
     * @todo complete this dock bloc comment
     * Allowed properties.
     * This method returns the array corresponding to the list of all allowed properties.
     *
     * @return array the array of allowed properties
     */
    protected static function allowed()
    {
        return [];
    }
}

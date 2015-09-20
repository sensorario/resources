<?php

/**
 * This is a summary
 *
 * This is a description
 */

namespace Sensorario\ValueObject;

use PHPUnit_Framework_TestCase;
use RuntimeException;

/**
 * This is a summary
 *
 * this is a descripion
 */
final class ValueObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * You can use ONLY allowed fields
     *
     * @expectedException RuntimeException
     */
    public function testNotallowedFieldThroghRuntimeException()
    {
        $fullName = FullNameValueObject::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
            'not'     => 'allowed',
        ]);
    }

    /**
     * Cannot forget mandator fields
     *
     * @expectedException RuntimeException
     */
    public function testMissingMandatoryFieldThroghRuntimeException()
    {
        $fullName = FullNameValueObject::box([]);
    }

    /**
     * You are not allowed to create a Value Object without mandatory fields
     */
    public function testValueObjectWithoutMandatoryProperties()
    {
        $valueObject = EmptyValueObject::box([
            // ...
        ]);

        $this->assertInstanceOf(
            'Sensorario\\valueObject\\EmptyValueObject',
            $valueObject
        );
    }

    /**
     * Is obvious, but mandatory fields are allowed by default
     *
     * this means that if you dont specify them as allowed, dont through exception
     */
    public function testMandatoryFieldsAreAuthomaticallyAllowed()
    {
        $fullName = FullNameValueObject::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ]);
    }

    /**
     * Mmmm a test for a getter.
     *
     * Maybe just for code coverage, ... 
     */
    public function testGetters()
    {
        $fullName = FullNameValueObject::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ]);

        $this->assertEquals(
            'Simone',
            $fullName->name()
        );
    }
}

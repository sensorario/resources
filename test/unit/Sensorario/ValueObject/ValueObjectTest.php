<?php

namespace Sensorario\ValueObject;

use PHPUnit_Framework_TestCase;
use RuntimeException;

final class ValueOjectTest extends PHPUnit_Framework_TestCase
{
    /**
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
     * @expectedException RuntimeException
     */
    public function testMissingMandatoryFieldThroghRuntimeException()
    {
        $fullName = FullNameValueObject::box([]);
    }

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

    public function testMandatoryFieldsAreAuthomaticallyAllowed()
    {
        $fullName = FullNameValueObject::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ]);
    }

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

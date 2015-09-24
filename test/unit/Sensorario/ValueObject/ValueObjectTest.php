<?php

/**
 * This is a summary
 *
 * This is a description
 */

namespace Sensorario\ValueObject;

use PHPUnit_Framework_TestCase;
use RuntimeException;
use Sensorario\ValueObject\Exception\UndefinedMandatoryPropertyException;
use Sensorario\ValueObject\Exception\InvalidKeyException;

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
     * @expectedException        Sensorario\ValueObject\Exceptions\InvalidKeyException
     * @expectedExceptionMessage Key not is not allowed
     */
    public function testNotAllowedFieldThroghRuntimeException()
    {
        $foo = Foo::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
            'not'     => 'allowed',
        ]);
    }

    /**
     * Cannot forget mandator fields
     *
     * @expectedException        Sensorario\ValueObject\Exceptions\UndefinedMandatoryPropertyException
     * @expectedExceptionMessage Property name is mandatory but not set
     */
    public function testMissingMandatoryFieldThroghRuntimeException()
    {
        $foo = Foo::box([]);
    }

    /**
     * Is obvious, but mandatory fields are allowed by default
     *
     * this means that if you dont specify them as allowed, dont through exception
     */
    public function testMandatoryFieldsAreAuthomaticallyAllowed()
    {
        $foo = Foo::box([
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
        $foo = Foo::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ]);

        $this->assertEquals(
            'Simone',
            $foo->name()
        );
    }

    /**
     * @expectedException Sensorario\ValueObject\Exceptions\InvalidFactoryMethodException
     */
    public function testFactoryMethodShouldBeBox()
    {
        Bar::invalidFactoryName();
    }

    /**
     * A value object could have default vaules
     */
    public function testCanHaveDefaultValues()
    {
        $foo = Bar::box();

        $this->assertEquals(
            'Firefox',
            $foo->name()
        );
    }

    public function testPropertyExists()
    {
        $foo = Bar::box();

        $this->assertFalse(
            $foo->propertyExists('nonExistentProperty')
        );
    }

    public function testAllowAccessToProperties()
    {
        $foo = Bar::box([
            'name' => 'Firefox'
        ]);

        $this->assertEquals(
            'Firefox',
            $foo->get('name')
        );
    }

    public function testAllowAccessToPropertiesThroughDefaultValue()
    {
        $foo = Bar::box();

        $this->assertEquals(
            'Firefox',
            $foo->get('name')
        );
    }

    /**
     * @expectedException RuntimeException
     */
    public function testThroughExceptionWhenNoValuesProvided()
    {
        $foo = Bar::box();
        $foo->get('foo');
    }
}

/**
 * Example class
 *
 * This kind of Vo provide one mandatory field, and two allowed
 */
final class Foo extends ValueObject
{
    /**
     * Only one mandatory field here
     */
    public static function mandatory()
    {
        return [
            'name',
        ];
    }

    /**
     * This VO allows two fields
     */
    public static function allowed()
    {
        return [
            'name',
            'surname',
        ];
    }
}

/**
 * In this case, we have a default value
 */
final class Bar extends ValueObject
{
    /**
     * Only one mandatory field here
     */
    public static function allowed()
    {
        return [
            'name',
        ];
    }

    /**
     * Only one default value
     */
    public static function defaults()
    {
        return [
            'name' => 'Firefox',
        ];
    }
}

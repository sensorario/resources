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
     * @expectedException        RuntimeException
     * @expectedExceptionMessage Key not is not allowed
     */
    public function testNotallowedFieldThroghRuntimeException()
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
     * @expectedException        RuntimeException
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

    /** @todo some names are reserved ... */

    /**
     * A value object could have default vaules
     */
    public function testCanHaveDefaultValues()
    {
        $foo = Bar::hello();

        $this->assertEquals(
            'Firefox',
            $foo->name()
        );
    }

    public function testProperyExists()
    {
        $foo = Bar::hello();

        $this->assertFalse(
            $foo->properyExists('nonExistentProperty')
        );
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

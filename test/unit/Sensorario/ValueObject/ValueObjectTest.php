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
    public function testCanHaveDefaultValues()
    {
        $foo = Bar::hello();

        $this->assertEquals(
            'Firefox',
            $foo->name()
        );
    }
}

final class Foo extends ValueObject
{
    public static function mandatory()
    {
        return [
            'name',
        ];
    }

    public static function allowed()
    {
        return [
            'name',
            'surname',
        ];
    }
}

final class Bar extends ValueObject
{
    public static function allowed()
    {
        return [
            'name',
        ];
    }

    public static function defaults()
    {
        return [
            'name' => 'Firefox',
        ];
    }
}

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

use DateInterval;
use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\Resources\BirthDay;
use Sensorario\Services\ExportJSON;

final class ValueObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Method `.*::.*()` is not yet implemented#
     */
    public function testExceptionIsThrownWhenNotYetImplementedMethodIsCalled()
    {
        $foo = Foo::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ]);

        $foo->notYetImplementedMethod();
    }

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Key `.*::.*` is not allowed#
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
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Property `.*::.*` is mandatory but not set#
     */
    public function testMissingMandatoryFieldThroghRuntimeException()
    {
        $foo = Foo::box([]);
    }

    public function testMandatoryFieldsAreAuthomaticallyAllowed()
    {
        $foo = Foo::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ]);
    }

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
     * @expectedException RuntimeException
     */
    public function testFactoryMethods()
    {
        Bar::invalidFactoryName();
    }

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
            $foo->hasProperty('nonExistentProperty')
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

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessage Value `42` is not allowed for key `someApiParameter`
     */
    public function testAllowedValueForAField()
    {
        SomeApiRequest::box([
            'someApiParameter' => 42
        ]);
    }

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Attribute `.*` must be an object#
     */
    public function testPropertyCouldBeAnObject()
    {
        $birthday = BirthDay::box([
            'date' => 'not a date',
        ]);
    }

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Attribute `.*` must be an object of type DateTime#
     */
    public function testPropertyCouldBeTheRightnObject()
    {
        $birthday = BirthDay::box([
            'date' => new DateInterval('P1D'),
        ]);
    }

    public function testPropertiesTypeWhenObject()
    {
        $birthday = BirthDay::box([
            'date' => new DateTime('2015'),
        ]);

        $this->assertEquals(
            'DateTime',
            $birthday->getPropertyType('date')
        );
    }

    public function testPropertiesTypeWhenString()
    {
        $foo = Foo::box([
            'name' => 'Simone'
        ]);

        $this->assertEquals(
            'string',
            $foo->getPropertyType('name')
        );
    }

    public function testPropertiesAccessor()
    {
        $foo = Foo::box([
            'name' => 'Sam',
        ]);

        $this->assertEquals([
                'name' => 'Sam',
            ],
            $foo->properties()
        );
    }

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Property `.*::.*` is mandatory but not set#
     */
    public function test()
    {
        MandatoryDependency::box([
            'foo' => 'bar',
            'world' => 'bar',
        ]);
    }
}

final class MandatoryDependency extends ValueObject
{
    public static function mandatory()
    {
        return [
            'foo',
            'hello' => [
                'if_present' => 'world',
            ]
        ];
    }

    public static function allowed()
    {
        return [
            'hello',
            'world',
        ];
    }
}

final class SomeApiRequest extends ValueObject
{
    public static function mandatory()
    {
        return [
            'someApiParameter',
        ];
    }

    public static function allowedValues()
    {
        return [
            'someApiParameter' => [
                'hello',
                'world'
            ],
        ];
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

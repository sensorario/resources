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
use Sensorario\ValueObject\Exception\InvalidKeyException;
use Sensorario\ValueObject\Exception\UndefinedMandatoryPropertyException;

final class ValueObjectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException              Sensorario\ValueObject\Exceptions\InvalidMethodException
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
     * @expectedException              Sensorario\ValueObject\Exceptions\InvalidKeyException
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
     * @expectedException              Sensorario\ValueObject\Exceptions\UndefinedMandatoryPropertyException
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
     * @expectedException Sensorario\ValueObject\Exceptions\InvalidFactoryMethodException
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
     * @expectedException Sensorario\ValueObject\Exceptions\InvalidKeyOrValueException
     */
    public function testThroughExceptionWhenNoValuesProvided()
    {
        $foo = Bar::box();
        $foo->get('foo');
    }

    /**
     * @expectedException        Sensorario\ValueObject\Exceptions\InvalidValueException
     * @expectedExceptionMessage Value `42` is not allowed for key `someApiParameter`
     */
    public function testAllowedValueForAField()
    {
        SomeApiRequest::box([
            'someApiParameter' => 42
        ]);
    }

    /**
     * @expectedException              Sensorario\ValueObject\Exceptions\InvalidTypeException
     * @expectedExceptionMessageRegExp #Attribute `.*` must be an object#
     */
    public function testPropertyCouldBeAnObject()
    {
        $birthday = BirthDay::box([
            'date' => 'not a date',
        ]);
    }

    /**
     * @expectedException              Sensorario\ValueObject\Exceptions\InvalidTypeException
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

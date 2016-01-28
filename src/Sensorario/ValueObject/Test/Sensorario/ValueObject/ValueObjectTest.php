<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Test\ValueObject;

use DateInterval;
use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\ValueObject\Resources\MandatoryDependency;
use Sensorario\ValueObject\Resources\SomeApiRequest;
use Sensorario\ValueObject\Resources\UserCreationEvent;
use Sensorario\ValueObject\Test\Resources\Bar;
use Sensorario\ValueObject\Test\Resources\BirthDay;
use Sensorario\ValueObject\Test\Resources\ComposedValueObject;
use Sensorario\ValueObject\Test\Resources\Foo;

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
        Foo::box([
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
        Foo::box([]);
    }

    public function testMandatoryFieldsAreAuthomaticallyAllowed()
    {
        Foo::box([
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
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Invalid factory method#
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
     * @expectedExceptionMessageRegExp #Attribute `.*` must be of type `array`#
     */
    public function testPropertyCouldBeAScalar()
    {
        SomeApiRequest::box([
            'fields' => 'not a scalar',
        ]);
    }

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Attribute `.*` must be of type `.*`#
     */
    public function testPropertyCouldBeAnObject()
    {
        BirthDay::box([
            'date' => 'not a date',
        ]);
    }

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Attribute `.*` must be an object of type DateTime#
     */
    public function testPropertyCouldBeTheRightnObject()
    {
        BirthDay::box([
            'date' => new DateInterval('P1D'),
        ]);
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
    public function testWhenCondition()
    {
        MandatoryDependency::box([
            'foo' => 'bar',
            'mandatory_mello' => 'bar',
        ]);
    }

    public function testShouldNotFail()
    {
        MandatoryDependency::box([
            'foo' => 'bar',
        ]);
    }

    public function testValueObjectComposition()
    {
        $composition = ComposedValueObject::box([
            'credentials' => Foo::box([
                'name' => 'Sam'
            ]),
        ]);

        $this->assertEquals([
                'credentials' => [
                    'name' => 'Sam',
                ]
            ],
            $composition->properties()
        );
    }

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #When property `.*` has value `.*` also `.*` is mandatory#
     */
    public function testMandatoryValuesWhenPropertyAssumeAValue()
    {
        UserCreationEvent::box([
            'type' => 'guest',
        ]);
    }

    public function test()
    {
        UserCreationEvent::box([
            'type' => 'human',
            'username' => 'Sensorario',
        ]);
    }
}

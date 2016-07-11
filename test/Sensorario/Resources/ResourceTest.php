<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Test\Resources;

use DateInterval;
use DateTime;
use PHPUnit_Framework_TestCase;
use Resources\Bar;
use Resources\BirthDay;
use Resources\ComposedResource;
use Resources\Foo;
use Resources\MandatoryDependency;
use Resources\ResourceWithoutRules;
use Resources\SomeApiRequest;
use Resources\UserCreationEvent;
use Sensorario\Resources\Container;

final class ResourceTest extends PHPUnit_Framework_TestCase
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

    public function testResourcesHasMagicMethod()
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
     * @expectedException        RuntimeException
     * @expectedExceptionMessage Oops! Property name requested is empty string!!
     */
    public function testExceptionMessageInCaseOfEmptyPropertyName()
    {
        $foo = Foo::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ]);

        $this->assertEquals(
            'Simone',
            $foo->get('')
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

    /** @dataProvider propertiesProvider */
    public function testHasProperties($result, $properties)
    {
        $foo = UserCreationEvent::box([
            'type' => 'human',
            'username' => 'Sensorario',
        ]);

        $this->assertSame(
            $result,
            $foo->hasProperties($properties)
        );
    }

    public function propertiesProvider()
    {
        return [
            [false, ['buppa']],
            [true, ['type', 'username']],
        ];
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

    public function testResourcesComposition()
    {
        $composition = ComposedResource::box([
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

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #When property `.*` is an object class, must be defined in Resources::rules()#
     */
    public function testAnExceptionIsThrownIfAPropertyIsAnObjectButClassInNotDefinedInRuleMethod()
    {
        ResourceWithoutRules::box([
            'datetime' => new DateTime(),
        ]);
    }

    public function testAllowedFieldsCouldBeDefinedLazy()
    {
        $this->getMockBuilder('\\Sensorario\\Resources\\Container')
            ->disableOriginalConstructor()
            ->getMock();

        $resource = new \Sensorario\Resources\Resource(
            [],
            new \Sensorario\Resources\Validators\ResourcesValidator()
        );

        $this->assertEquals(
            [],
            $resource->allowed()
        );

        $resource->applyConfiguration(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'allowed' => [ 'allowed_property_name' ],
                        ]
                    ],
                    'unused_resource' => [
                        'constraints' => [
                            'allowed' => [ 'bar' ],
                        ]
                    ],
                ],
            ])
        );

        $this->assertEquals(
            [ 'allowed_property_name' ],
            $resource->allowed('foo')
        );
    }
}

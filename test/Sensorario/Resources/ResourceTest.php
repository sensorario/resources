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
use Sensorario\Resources\Resource;
use Sensorario\Resources\Validators\ResourcesValidator;

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

    public function testDefaultValuesTwo()
    {
        $resource = new Resource(
            [],
            new ResourcesValidator()
        );

        $this->assertEquals(
            [],
            $resource->allowed()
        );

        $resource->applyConfiguration(
            'bar',
            new Container([
                'resources' => [
                    'bar' => [
                        'constraints' => [
                            'allowed' => [ 'allowed_property_name' ],
                        ]
                    ],
                ],
            ])
        );

        $this->assertEquals(
            [ 'allowed_property_name' ],
            $resource->allowed('bar')
        );
    }

    public function testDefaultValues()
    {
        $resource = Resource::fromConfiguration(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'mandatory' => [
                                'ciambella',
                            ],
                            'defaults' => [
                                'ciambella' => '42',
                            ],
                        ]
                    ],
                ],
            ])
        );

        $resource = $resource::box([
        ]);

        $this->assertEquals(
            '42',
            $resource->get('ciambella')
        );
    }

    public function testResourceShouldBeCreatedViaContainer()
    {
        $resource = Resource::fromConfiguration(
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

    /**
     * @expectedException              RuntimeException
     * @expectedExceptionMessageRegExp #Property `.*::.*` is mandatory but not set#
     */
    public function testDependentMandatoryProperties()
    {
        $resource = Resource::fromConfiguration(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'allowed' => [
                                'bar',
                            ],
                            'mandatory' => [
                                'mandatory_property_name',
                                'foo' => [
                                    'when' => [
                                        'property' => 'bar',
                                        'condition' => 'is_present',
                                    ]
                                ],
                            ],
                        ]
                    ],
                ],
            ])
        );

        $resource::box([
            'mandatory_property_name' => '42',
            'bar' => 'beer',
        ]);
    }

    public function testMandatoryConstraintsAreAutomaticallyAllowed()
    {
        $resource = Resource::fromConfiguration(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'mandatory' => [ 'mandatory_property' ],
                        ]
                    ],
                ],
            ])
        );

        $this->assertEquals(
            [ 'mandatory_property' ],
            $resource->allowed('foo')
        );
    }

    public function testPropertyType()
    {
        $resource = Resource::fromConfiguration(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'mandatory' => [ 'date' ],
                            'rules' => [ 'date' => [ 'object' => 'DateTime' ] ],
                        ]
                    ],
                ],
            ])
        );

        $resource::box([
            'date' => new DateTime(),
        ]);
    }

    /**
     * @expectedException              RuntimeException
     */
    public function testAllowedValues()
    {
        $resource = Resource::fromConfiguration(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'allowed' => [ 'user_type' ],
                            'allowedValues' => [
                                'user_type' => [
                                    4, 
                                    7,
                                ],
                            ],
                        ],
                    ],
                ],
            ])
        );

        $resource::box([
            'user_type' => 3
        ]);
    }
}

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
use PHPUnit\Framework\TestCase;
use Resources\Bar;
use Resources\BirthDay;
use Resources\UndefinedObject;
use Resources\ComposedResource;
use Resources\Foo;
use Resources\MandatoryDependency;
use Resources\ResourceWithoutRules;
use Resources\SomeApiRequest;
use Resources\UserCreationEvent;
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Resource;
use Sensorario\Resources\Validators\ResourcesValidator;

final class ResourceTest extends TestCase
{
    /**
     * @expectedException              \Sensorario\Resources\Exceptions\UndefinedMethodException
     * @expectedExceptionMessageRegExp #Method `.*::.*()` is not yet implemented#
     */
    public function testExceptionIsThrownWhenNotYetImplementedMethodIsCalled()
    {
        $configurator = new Configurator(
            'empty_resource',
            new Container([
                'resources' => [
                    'empty_resource' => [
                        'constraints' => [],
                    ],
                ],
            ])
        );

        $resource = Resource::box([], $configurator);

        $resource->notYetImplementedMethod();
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\NotAllowedKeyException
     * @expectedExceptionMessageRegExp #Key `.*::.*` is not allowed#
     */
    public function testNotAllowedFieldThroghRuntimeException()
    {
        $configurator = new Configurator(
            'empty_resource',
            new Container([
                'resources' => [
                    'empty_resource' => [
                        'constraints' => [
                            'allowedValues' => [
                                'name',
                                'surname',
                            ],
                        ],
                    ],
                ],
            ])
        );

        $resource = Resource::box([
            'name' => 'Simone',
            'surname' => 'Gentili',
            'not allowed' => 'foo',
        ], $configurator);
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\PropertyException
     * @expectedExceptionMessageRegExp #Property `.*::.*` is mandatory but not set#
     */
    public function testMissingMandatoryFieldThroghRuntimeException()
    {
        $configurator = new Configurator(
            'empty_resource',
            new Container([
                'resources' => [
                    'empty_resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'name',
                            ],
                        ],
                    ],
                ],
            ])
        );

        $resource = Resource::box([
            'surname' => 'Gentili',
        ], $configurator);
    }

    public function testMandatoryFieldsAreAuthomaticallyAllowed()
    {
        $configurator = new Configurator(
            'empty_resource',
            new Container([
                'resources' => [
                    'empty_resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'name',
                                'surname',
                            ],
                        ],
                    ],
                ],
            ])
        );

        $resource = Resource::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ], $configurator);

        $this->assertEquals(
            'Simone',
            $resource->name()
        );
    }

    /**
     * @expectedException        Sensorario\Resources\Exceptions\PropertyNameEmptyException
     * @expectedExceptionMessage Oops! Property name requested is empty string!!
     */
    public function testExceptionMessageInCaseOfEmptyPropertyName()
    {
        $configurator = new Configurator(
            'empty_resource',
            new Container([
                'resources' => [
                    'empty_resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'name',
                                'surname',
                            ],
                        ],
                    ],
                ],
            ])
        );

        $resource = Resource::box([
            'name'    => 'Simone',
            'surname' => 'Gentili',
        ], $configurator);

        $this->assertEquals(
            'Simone',
            $resource->get('')
        );
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\FactoryMethodException
     * @expectedExceptionMessageRegExp #Invalid factory method#
     */
    public function testFactoryMethods()
    {
        Resource::invalidFactoryName();
    }

    public function testCanHaveDefaultValues()
    {
        $configurator = new Configurator(
            'empty_resource',
            new Container([
                'resources' => [
                    'empty_resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'name',
                            ],
                            'defaults' => [
                                'name' => 'Firefox',
                            ],
                        ],
                    ],
                ],
            ])
        );

        $resource = Resource::box([], $configurator);

        $this->assertEquals(
            'Firefox',
            $resource->name()
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
     * @expectedException Sensorario\Resources\Exceptions\NoValuesException
     */
    public function testThroughExceptionWhenNoValuesProvided()
    {
        $foo = Bar::box();
        $foo->get('foo');
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\AttributeTypeException
     * @expectedExceptionMessageRegExp #Attribute `.*` must be of type `array`#
     */
    public function testPropertyCouldBeAScalar()
    {
        SomeApiRequest::box([
            'fields' => 'not a scalar',
        ]);
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\NotObjectTypeFoundException
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
        $aSpecificRule = [ 'custom-validator' => 'email' ];

        $configurator = new Configurator(
            'email-resource',
            new Container([
                'resources' => [
                    'email-resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'name',
                            ],
                        ]
                    ],
                ],
            ])
        );

        $properties = [
            'name' => 'Simone',
        ];

        $resource = Resource::box($properties, $configurator);

        $this->assertEquals(
            $properties,
            $resource->properties()
        );
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\PropertyNotSetException
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
     * @expectedException              Sensorario\Resources\Exceptions\PropertyException
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
     * @expectedException              Sensorario\Resources\Exceptions\PropertyWithoutRuleException
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
            new Configurator(
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
            )
        );

        $this->assertEquals(
            [ 'allowed_property_name' ],
            $resource->allowed('bar')
        );
    }

    public function testDefaultValues()
    {
        $configurator = new Configurator(
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

        $resource = Resource::box(
            [],
            $configurator
        );

        $this->assertEquals(
            '42',
            $resource->get('ciambella')
        );
    }

    public function testResourceShouldBeCreatedViaContainer()
    {
        $container = new Container([
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
        ]);

        $this->assertEquals(
            [ 'allowed_property_name' ],
            $container->allowed('foo')
        );
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\PropertyNotSetException
     * @expectedExceptionMessageRegExp #Property `.*::.*` is mandatory but not set#
     */
    public function testDependentMandatoryProperties()
    {
        $configurator = new Configurator(
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

        $properties = [
            'mandatory_property_name' => '42',
            'bar' => 'beer',
        ];

        Resource::box(
            $properties,
            $configurator
        );
    }

    public function testMandatoryConstraintsAreAutomaticallyAllowed()
    {
        $container = new Container([
            'resources' => [
                'foo' => [
                    'constraints' => [
                        'mandatory' => [ 'mandatory_property' ],
                    ]
                ],
            ],
        ]);

        $this->assertEquals(
            [ 'mandatory_property' ],
            $container->allowed('foo')
        );
    }

    public function testPropertyType()
    {
        $configurator = new Configurator(
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

        $properties = [
            'date' => new \DateTime(),
        ];

        Resource::box($properties, $configurator);
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\UnexpectedValueException
     * @expectedExceptionMessageRegExp #Value `.*` is not allowed for key `.*`. Allowed values are:#
     */
    public function testAllowedValues()
    {
        $configurator = new Configurator(
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

        $properties = [ 'user_type' => 3 ];

        Resource::box(
            $properties,
            $configurator
        );
    }

    public function testRewriteRulesWithCondition()
    {
        $configurator = new Configurator(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'rewrite' => [
                            'width' => [
                                'set' => [
                                    'equals_to' => 'height',
                                ],
                                'when' => [
                                    'greater_than' => 'height',
                                ],
                            ],
                        ],
                        'constraints' => [
                            'allowed' => [
                                'width',
                                'height',
                            ],
                        ],
                    ], 
                ],
            ])
        );
        $properties = [
            'width'  => 3000,
            'height' => 400,
        ];

        $box = Resource::box(
            $properties,
            $configurator
        );

        $overwritternProperties = [
            'width'  => 400,
            'height' => 400,
        ];

        $overWrittenBox = Resource::box(
            $overwritternProperties,
            $configurator
        );

        $this->assertEquals(
            $overWrittenBox,
            $box
        );
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\OutOfRangeException
     * @expectedExceptionMessageRegExp #Value `.*` is out of range: `.*`.#
     */
    public function testAcceptRangeOfValues()
    {
        $configurator = new Configurator(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'allowedRanges' => [
                                'age' => [
                                    'more_than' => 3,
                                    'less_than' => 42,
                                ],
                            ],
                            'allowed' => [
                                'age'
                            ],
                        ],
                    ],
                ],
            ])
        );

        Resource::box(
            [ 'age' => 2 ],
            $configurator
        );
    }

    public function testAllResourcesInheritGlobalAllowingConfiguration()
    {
        $configurator = new Configurator(
            'foo',
            new Container([
                'globals' => [
                    'allowed' => [
                        'width',
                        'height',
                    ],
                ],
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'allowed' => [
                                'foo_size',
                            ],
                        ],
                    ], 
                    'bar' => [
                        'constraints' => [
                            'allowed' => [
                                'bar_size',
                            ],
                        ],
                    ], 
                ],
            ])
        );

        $resource = Resource::box(
            [],
            $configurator
        );

        $this->assertEquals(
            ['foo_size', 'width', 'height'],
            $resource->allowed()
        );
    }

    /**
     * @expectedException Sensorario\Resources\Exceptions\PropertyException
     */
    public function testHasMandatoryPropertiesWhenAnotherOneHasAParticularValue()
    {
        $configurator = new Configurator(
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
                                        'has_value' => '42',
                                    ]
                                ],
                            ],
                        ]
                    ],
                ],
            ])
        );

        $properties = [
            'bar' => '42',
        ];

        Resource::box(
            $properties,
            $configurator
        );
    }

    /**
     * @expectedException Sensorario\Resources\Exceptions\EmailException
     */
    public function testEmailValidationFails()
    {
        $configurator = new Configurator(
            'email-resource',
            new Container([
                'resources' => [
                    'email-resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'first-email',
                            ],
                            'rules' => [
                                'first-email' => [ 'custom-validator' => 'email' ],
                            ],
                        ]
                    ],
                ],
            ])
        );

        $properties = [
            'first-email' => 'invalid email',
        ];

        Resource::box($properties, $configurator);
    }

    /**
     * @expectedException              Sensorario\Resources\Exceptions\WrongPropertyValueException
     * @expectedExceptionMessageRegExp #Property .* must be an integer!#
     */
    public function testIntegersCanBeDefinedWithNumberRule()
    {
        $configurator = new Configurator(
            'type-with-number',
            new Container([
                'resources' => [
                    'type-with-number' => [
                        'constraints' => [
                            'mandatory' => [ 'a-magic-number' ],
                            'rules' => [ 'a-magic-number' => [ 'scalar' => 'integer' ] ],
                        ]
                    ],
                ],
            ])
        );

        $properties = [
            'a-magic-number' => '42',
        ];

        $resource = Resource::box($properties, $configurator);
    }

    public function testEmailValidation()
    {
        $configurator = new Configurator(
            'email-resource',
            new Container([
                'resources' => [
                    'email-resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'first-email',
                            ],
                            'rules' => [
                                'first-email' => [ 'custom-validator' => 'email' ],
                            ],
                        ]
                    ],
                ],
            ])
        );

        $properties = [
            'first-email' => 'sensorario@gmail.com',
        ];

        $resource = Resource::box($properties, $configurator);

        $this->assertEquals(
            'sensorario@gmail.com',
            $resource->get('first-email')
        );
    }

    /** @dataProvider rules */
    public function testRulesKnowsIfRuleIsDefinedOrNot($expectation, $ruleName)
    {
        $configurator = new Configurator(
            'email-resource',
            new Container([
                'resources' => [
                    'email-resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'first-email',
                            ],
                            'rules' => [
                                'first-email' => [ 'custom-validator' => 'email' ],
                            ],
                        ]
                    ],
                ],
            ])
        );

        $properties = [
            'first-email' => 'sensorario@gmail.com',
        ];

        $resource = Resource::box($properties, $configurator);

        $this->assertEquals(
            $expectation,
            $resource->isRuleDefinedFor($ruleName)
        );
    }

    public function rules()
    {
        return [
            [true, 'first-email'],
            [false, 'non-existent-field-name'],
        ];
    }

    public function testProvideRule()
    {
        $aSpecificRule = [ 'custom-validator' => 'email' ];

        $configurator = new Configurator(
            'email-resource',
            new Container([
                'resources' => [
                    'email-resource' => [
                        'constraints' => [
                            'mandatory' => [
                                'first-email',
                            ],
                            'rules' => [
                                'first-email' => $aSpecificRule,
                            ],
                        ]
                    ],
                ],
            ])
        );

        $properties = [
            'first-email' => 'sensorario@gmail.com',
        ];

        $resource = Resource::box($properties, $configurator);

        $this->assertEquals(
            $aSpecificRule,
            $resource->getRule('first-email')->asArray()
        );
    }

    /**
     * @expectedException Sensorario\Resources\Exceptions\PropertyWithoutRuleException
     * @expectedExceptionMessage Property date is an object but is not defined in rules
     */
    public function testUndefinedObject()
    {
        UndefinedObject::box([
            'date' => new \stdClass(),
        ]);
    }
}

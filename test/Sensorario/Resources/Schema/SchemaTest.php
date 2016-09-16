<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Test\Resources\Schema;

use PHPUnit_Framework_TestCase;
use Sensorario\Resources\Schema\Schema;

final class SchemaTest
    extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parser = $this
            ->getMockBuilder('Sensorario\Resources\Schema\Parser')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\NoIdException
     */
    public function testIdMustBeMandatory()
    {
        $this->parser->expects($this->once())
            ->method('parseSchema')
            ->will($this->throwException(
                new \Sensorario\Resources\Schema\Exceptions\NoIdException()
            ));

        $this->emptySchema = new Schema(
            $this->parser, [
                'title' => 'ciao',
                'type' => 'picchio',
                'properties' => [],
                'anotherSchema' => [
                    'title' => 'ciao',
                ]
            ]
        );
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\NoTypeException
     */
    public function testAlsoNestedSchemaMustHaveType()
    {
        $this->parser->expects($this->once())
            ->method('parseSchema')
            ->will($this->throwException(
                new \Sensorario\Resources\Schema\Exceptions\NoTypeException()
            ));

        $this->emptySchema = new Schema(
            $this->parser, [
                'title' => 'ciao',
                'properties' => [],
                'anotherSchema' => [
                    'title' => 'ciao',
                ]
            ]
        );
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\NoPropertiesException
     */
    public function testSchemasMustHaveProperties()
    {
        $this->parser->expects($this->once())
            ->method('parseSchema')
            ->will($this->throwException(
                new \Sensorario\Resources\Schema\Exceptions\NoPropertiesException()
            ));

        $completeSchema = [
            'title' => 'this is the root schema',
            'type' => Schema::PRIMITIVE_DEFAULT,
        ];

        $schema = new Schema(
            $this->parser,
            $completeSchema
        );
    }

    public function testMandatories()
    {
        $completeSchema = new Schema(
            $this->parser, [
                'title' => 'this is the root schema',
                'type' => Schema::PRIMITIVE_DEFAULT,
                'properties' => [
                    // no properties
                ],
                'anotherSchema' => [
                    'type' => Schema::PRIMITIVE_DEFAULT,
                    'title' => 'this is subschema',
                    'properties' => [],
                ],
            ]
        );

        $this->assertEquals(
            1,
            $completeSchema->countSubSchemas()
        );
    }

    public function testEmptySchemaHasNoSubschemas()
    {
        $this->emptySchema = new Schema(
            $this->parser, [
                'title' => 'ciao',
                'type' => Schema::PRIMITIVE_DEFAULT,
                'properties' => [
                    // no properties
                ],
            ]
        );

        $this->assertEquals(
            0,
            $this->emptySchema->countSubSchemas()
        );
    }

    public function testTitleMustBeDefined()
    {
        $this->emptySchema = new Schema(
            $this->parser, [
                'title' => 'ciao',
                'type' => Schema::PRIMITIVE_DEFAULT,
                'properties' => [
                    // no properties
                ],
            ]
        );

        $this->assertEquals(
            'ciao',
            $this->emptySchema->getTitle()
        );
    }

    public function testRecognizeRootSchema()
    {
        $rootSchema = [
            'title' => 'this is the root schema',
            'type' => Schema::PRIMITIVE_DEFAULT,
            'properties' => [
                // no properties
            ],
        ];

        $schema = new Schema(
            $this->parser,
            $rootSchema
        );

        $this->assertEquals(
            $rootSchema,
            $schema->completeSchema()
        );
    }

    public function testNestedSchemas()
    {
        $completeSchema = [
            'title' => 'this is the root schema',
            'type' => Schema::PRIMITIVE_DEFAULT,
            'properties' => [
                // no properties
            ],
            'anotherSchema' => [
                'type' => Schema::PRIMITIVE_DEFAULT,
                'title' => 'this is subschema',
                'properties' => [],
            ],
        ];

        $schema = new Schema(
            $this->parser,
            $completeSchema
        );

        $this->assertEquals(
            $completeSchema,
            $schema->completeSchema()
        );
    }

    public function testListOfSchemas()
    {
        $completeSchema = [
            'title' => 'this is the root schema',
            'type' => Schema::PRIMITIVE_DEFAULT,
            'properties' => [],
            'anotherSchema' => [
                'title' => 'this is subschema',
                'type' => Schema::PRIMITIVE_DEFAULT,
                'properties' => [],
            ],
        ];

        $schema = new Schema(
            $this->parser,
            $completeSchema
        );

        $this->assertEquals(
            ['root', 'anotherSchema'],
            $schema->schemaNames()
        );
    }

    public function testNestedNestedSchemas()
    {
        $completeSchema = [
            'title' => 'this is the root schema',
            'type' => Schema::PRIMITIVE_DEFAULT,
            'properties' => [],
            'anotherSchema' => [
                'title' => 'this is subschema',
                'type' => Schema::PRIMITIVE_DEFAULT,
                'properties' => [],
                'otherSchema' => [
                    'title' => 'this is other schema',
                    'type' => Schema::PRIMITIVE_DEFAULT,
                    'properties' => [],
                ],
            ],
        ];

        $schema = new Schema(
            $this->parser,
            $completeSchema
        );

        $this->assertEquals(
            ['root', 'anotherSchema', 'otherSchema'],
            $schema->schemaNames()
        );

        $this->assertEquals(
            2,
            $schema->countSubSchemas()
        );
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\NoPropertyTypeException
     */
    public function testPropertyMustHaveType()
    {
        $this->emptySchema = new Schema(
            $this->parser, [
                'title' => 'ciao',
                'type' => Schema::PRIMITIVE_DEFAULT,
                'properties' => [
                    'id' => [
                        // 'type' => Schema::PRIMITIVE_INTEGER,
                    ],
                ],
            ]
        );
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\InvalidTypeException
     */
    public function testSchemaDoesNotAcceptInvalidType()
    {
        $this->parser->expects($this->once())
            ->method('parseSchema')
            ->will($this->throwException(
                new \Sensorario\Resources\Schema\Exceptions\InvalidTypeException()
            ));

        $this->emptySchema = new Schema(
            $this->parser, [
                'title' => 'ciao',
                'type' => 'foo',
                'properties' => [
                    // no properties
                ],
            ]
        );
    }

    public function testProvideAllProperties()
    {
        $schema = new Schema(
            $this->parser, [
                'title' => 'schema with integers',
                'type' => Schema::PRIMITIVE_INTEGER,
                'properties' => [
                    'year' => ['type' => Schema::PRIMITIVE_INTEGER],
                ],
            ]
        );

        $this->assertEquals(
            ['year' => ['type' => Schema::PRIMITIVE_INTEGER]],
            $schema->properties()
        );
    }

    public function testValidateJson()
    {
        $schema = new Schema(
            $this->parser, [
                'title' => 'schema with integers',
                'type' => Schema::PRIMITIVE_INTEGER,
                'properties' => [
                    'year' => ['type' => Schema::PRIMITIVE_INTEGER],
                ],
            ]
        );

        $json = '{"year":"2016"}';

        $obj = $schema->validate($json);

        $this->assertEquals(
            2016,
            $obj->year
        );
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\NotAllowedPropertyException
     */
    public function testNoAllowedProperties()
    {
        $this->parser->expects($this->once())
            ->method('parseSchema')
            ->will($this->throwException(
                new \Sensorario\Resources\Schema\Exceptions\NotAllowedPropertyException()
            ));

        $schema = new Schema(
            $this->parser, [
                'title' => 'schema with integers',
                'type' => Schema::PRIMITIVE_INTEGER,
                'properties' => [
                    'year' => ['type' => Schema::PRIMITIVE_INTEGER],
                ],
            ]
        );

        $json = '{"year":"2016","foo":"asdfasd"}';

        $obj = $schema->validate($json);
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\NotAllowedValueException
     */
    public function testNoAllowedPropertyValue()
    {
        $schema = new Schema(
            $this->parser, [
                'title' => 'schema with integers',
                'type' => Schema::PRIMITIVE_INTEGER,
                'properties' => [
                    'year' => ['type' => Schema::PRIMITIVE_INTEGER],
                ],
            ]
        );

        $json = '{"year":"hello"}';

        $obj = $schema->validate($json);
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\MissingPropertyException
     */
    public function testFindMissingPropertiesDuringJsonValidation()
    {
        $schema = new Schema(
            $this->parser, [
                'title' => 'schema with integers',
                'type' => Schema::PRIMITIVE_INTEGER,
                'properties' => [
                    'year' => ['type' => Schema::PRIMITIVE_INTEGER],
                    'month' => ['type' => Schema::PRIMITIVE_INTEGER],
                ],
                'required' => ['year', 'month'],
            ]
        );

        $json = '{"year":"2016"}';

        $obj = $schema->validate($json);
    }

    public function testEachSuSchemaCanDefineRequiredProperties()
    {
        $schema = new Schema(
            $this->parser, [
                'title' => 'schema with integers',
                'type' => Schema::PRIMITIVE_INTEGER,
                'properties' => [
                    'year' => ['type' => Schema::PRIMITIVE_INTEGER],
                    'month' => ['type' => Schema::PRIMITIVE_INTEGER],
                ],
                'required' => ['year', 'month'],
                'anotherSchema' => [
                    'title' => 'schema with integers',
                    'type' => Schema::PRIMITIVE_INTEGER,
                    'properties' => [
                        'day' => ['type' => Schema::PRIMITIVE_INTEGER],
                    ],
                    'required' => ['day'],
                ]
            ]
        );

        $required = ['year', 'month', 'day'];

        $this->assertEquals(
            $required,
            $schema->required()
        );
    }

    public function testValidFormat()
    {
        $schema = new Schema(
            $this->parser, [
                'title' => 'schema with integers',
                'type' => Schema::PRIMITIVE_INTEGER,
                'properties' => [
                    'year' => ['type' => Schema::PRIMITIVE_INTEGER],
                    'month' => ['type' => Schema::PRIMITIVE_INTEGER],
                ],
                'required' => ['year', 'month'],
                'anotherSchema' => [
                    'title' => 'schema with integers',
                    'type' => Schema::PRIMITIVE_INTEGER,
                    'properties' => [
                        'day' => ['type' => Schema::PRIMITIVE_INTEGER],
                    ],
                    'required' => ['day'],
                ]
            ]
        );

        $json = '{"year":"2016","month":"33","day":"3"}';

        $schema->validate($json);
    }

    /**
     * @expectedException Sensorario\Resources\Schema\Exceptions\UndefinedArrayItemsTypeException
     */
    public function testArrayTypeMustDefineItemsType()
    {
        $schema = new Schema(
            $this->parser, [
                'title' => 'An order with all articles',
                'type' => Schema::PRIMITIVE_OBJECT,
                'properties' => [
                    'header' => [
                        'type' => Schema::PRIMITIVE_ARRAY
                    ],
                ],
                'required' => ['header'],
            ]
        );

        $json = '{"header":"2016"}';

        $schema->validate($json);
    }
}

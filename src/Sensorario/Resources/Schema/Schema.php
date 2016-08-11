<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Schema;

use RuntimeException;

final class Schema
{
    const PRIMITIVE_ARRAY   = 'array';
    const PRIMITIVE_BOOLEAN = 'boolean';
    const PRIMITIVE_DEFAULT = Schema::PRIMITIVE_NULL;
    const PRIMITIVE_INTEGER = 'integer';
    const PRIMITIVE_NULL    = 'null';
    const PRIMITIVE_NUMBER  = 'number';
    const PRIMITIVE_OBJECT  = 'object';
    const PRIMITIVE_STRING  = 'string';

    private $completeSchema;

    private $schemaNames = [];

    private $required = [];

    private $validTypes = [
        self::PRIMITIVE_ARRAY,
        self::PRIMITIVE_BOOLEAN,
        self::PRIMITIVE_DEFAULT,
        self::PRIMITIVE_INTEGER,
        self::PRIMITIVE_NULL,
        self::PRIMITIVE_NUMBER,
        self::PRIMITIVE_OBJECT,
        self::PRIMITIVE_STRING,
    ];

    private $subSchemaCounter = 0;

    private $properties = [];

    public function __construct(
        Parser $parser,
        $schema
    ) {
        $this->completeSchema = $schema;
        $this->schemaNames[] = 'root';
        $this->parser = $parser;
        $this->parseSchema($this->completeSchema);
    }

    private function parseSchema($schema)
    {
        $this->parser->setSchema($schema);
        $this->parser->setValidTypes($this->validTypes);
        $this->parser->parseSchema();

        foreach ($schema['properties'] as $name => $def) {
            $this->properties[$name] = $def;
            if (!isset($def['type'])) {
                throw new Exceptions\NoPropertyTypeException();
            }
        }

        if (isset($schema['required'])) {
            $this->required = array_merge(
                $this->required,
                $schema['required']
            );
        }

        foreach ($schema as $key => $value) {
            if (!in_array($key, ['required', 'properties', 'title', 'type'])) {
                $this->schemaNames[] = $key;
                $this->subSchemaCounter++;
                $this->parseSchema($value);
            }
        }
    }

    public function countSubSchemas()
    {
        return $this->subSchemaCounter;
    }

    public function completeSchema()
    {
        return $this->completeSchema;
    }

    public function schemaNames()
    {
        return $this->schemaNames;
    }

    public function getTitle()
    {
        return $this->completeSchema['title'];
    }

    /** @todo move this inside an applipcation service */
    public function validate($json) 
    {
        $jsonAsArray = json_decode($json, true);

        foreach ($jsonAsArray as $name => $property) {
            if (!isset($this->properties()[$name])) {
                throw new Exceptions\NotAllowedPropertyException();
            }
        }

        foreach ($this->required as $requiredProperty) {
            if (!isset($jsonAsArray[$requiredProperty])) {
                throw new Exceptions\MissingPropertyException();
            }
        }

        foreach ($jsonAsArray as $name => $property) {
            $prop = $this->properties()[$name];
            if (gettype($jsonAsArray[$name]) != $prop['type']) {
                if ($prop['type'] == Schema::PRIMITIVE_INTEGER && is_numeric($jsonAsArray[$name])) {
                    continue;
                }

                if ($prop['type'] == Schema::PRIMITIVE_ARRAY) {
                    if (!isset($prop['items'])) {
                        throw new Exceptions\UndefinedArrayItemsTypeException();
                    }
                }

                throw new Exceptions\NotAllowedValueException();
            }
        }

        return json_decode($json);
    }

    public function properties()
    {
        return $this->properties;
    }

    public function required()
    {
        return $this->required;
    }
}

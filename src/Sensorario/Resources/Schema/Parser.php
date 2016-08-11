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

class Parser
{
    private $schema;

    private $validTypes;

    public function setSchema(array $schema)
    {
        $this->schema = $schema;
    }

    public function setValidTypes(array $validTypes)
    {
        $this->validTypes = $validTypes;
    }

    public function parseSchema()
    {
        if (!isset($this->schema['type'])) {
            throw new Exceptions\NoTypeException();
        }

        if (!in_array($this->schema['type'], $this->validTypes)) {
            throw new Exceptions\InvalidTypeException();
        }

        if (!isset($this->schema['properties'])) {
            throw new Exceptions\NoPropertiesException();
        }

        if (!isset($this->schema['id'])) {
            throw new Exceptions\NoIdException();
        }
    }
}

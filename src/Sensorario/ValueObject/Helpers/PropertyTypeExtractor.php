<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Helpers;

use Sensorario\ValueObject\Interfaces\Service;
use Sensorario\ValueObject\ValueObject;

final class PropertyTypeExtractor implements Service
{
    private $valueObject;

    private $propertyName;

    public function __construct(ValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    public function execute()
    {
        $property = $this->valueObject->get($this->propertyName);

        return is_object($property)
            ? get_class($property)
            : gettype($property)
        ;
    }
}

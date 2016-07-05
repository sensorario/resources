<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Helpers;

use Sensorario\Resources\Interfaces\Helper;
use Sensorario\Resources\Resource;

final class PropertyTypeExtractor implements Helper
{
    private $resource;

    private $propertyName;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    public function execute()
    {
        $property = $this->resource->get($this->propertyName);

        return is_object($property)
            ? get_class($property)
            : gettype($property)
        ;
    }
}

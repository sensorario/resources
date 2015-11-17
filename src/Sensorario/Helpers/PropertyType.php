<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Helpers;

use Sensorario\ValueObject\ValueObject;

final class PropertyType
{
    public static function asString(ValueObject $valueObject, $propertyName)
    {
        $property = $valueObject->get(
            $propertyName
        );

        return is_object($property)
            ? get_class($property)
            : gettype($property)
        ;
    }
}

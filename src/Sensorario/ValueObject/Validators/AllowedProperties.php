<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Validators;

use RuntimeException;
use Sensorario\ValueObject\Interfaces\Validator;
use Sensorario\ValueObject\ValueObject;

final class AllowedProperties implements Validator
{
    public static function check(ValueObject $valueObject)
    {
        $allowed = array_merge(
            $valueObject->allowed(),
            $valueObject->mandatory()
        );

        foreach ($valueObject->properties() as $key => $property) {
            if (!in_array($key, $allowed)) {
                throw new RuntimeException(
                    "Key `" . get_class($valueObject)
                    . "::\$$key` is not allowed"
                );
            }
        }
    }
}

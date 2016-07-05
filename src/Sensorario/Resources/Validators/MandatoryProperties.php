<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Validators;

use RuntimeException;
use Sensorario\Resources\Interfaces\Validator;
use Sensorario\Resources\Resource;

final class MandatoryProperties implements Validator
{
    public static function check(Resource $resource)
    {
        foreach ($resource->mandatory() as $key => $value) {
            if (isset($value['when'])) {
                $propertyName = $value['when']['property'];

                if (isset($value['when']['has_value'])) {
                    $propertyValue = $value['when']['has_value'];

                    foreach ($propertyValue as $value) {
                        if ($resource->get($propertyName) === $value && $resource->hasNotProperty($key)) {
                            throw new RuntimeException(
                                'When property `' . $key . '` has value '
                                . '`' . $value . '` also `' . $key . '` is mandatory'
                            );
                        }
                    }
                }

                if (
                    isset($value['when']['condition']) &&
                    $value['when']['condition'] === 'is_present' &&
                    $resource->hasProperty($propertyName) &&
                    $resource->hasNotProperty($key)
                ) {
                    throw new RuntimeException(
                        "Property `" . get_class($resource)
                        . "::\${$key}` is mandatory but not set"
                    );
                }
            }

            if (
                is_numeric($key) &&
                $resource->hasNotProperty($value) &&
                !isset($resource->defaults()[$value])
            ) {
                throw new RuntimeException(
                    "Property `" . get_class($resource)
                    . "::\$$value` is mandatory but not set"
                );
            }
        }
    }
}

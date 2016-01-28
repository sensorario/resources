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

final class MandatoryProperties implements Validator
{
    public static function check(ValueObject $valueObject)
    {
        foreach ($valueObject->mandatory() as $key => $value) {
            if (isset($value['when'])) {
                $propertyName = $value['when']['property'];

                if (isset($value['when']['has_value'])) {
                    $propertyValue = $value['when']['has_value'];

                    foreach ($propertyValue as $value) {
                        if ($valueObject->get($propertyName) === $value && $valueObject->hasNotProperty($key)) {
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
                    $valueObject->hasProperty($propertyName) &&
                    $valueObject->hasNotProperty($key)
                ) {
                    throw new RuntimeException(
                        "Property `" . get_class($valueObject)
                        . "::\${$key}` is mandatory but not set"
                    );
                }
            }

            if (
                is_numeric($key) &&
                $valueObject->hasNotProperty($value) &&
                !isset($valueObject->defaults()[$value])
            ) {
                throw new RuntimeException(
                    "Property `" . get_class($valueObject)
                    . "::\$$value` is mandatory but not set"
                );
            }
        }
    }
}

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
    private static function ensureHasPropery(
        ValueObject $valueObject,
        $propertyName,
        $errorMessage
    ) {
        if ($valueObject->hasNotProperty($propertyName)) {
            throw new RuntimeException($errorMessage);
        }
    }

    public static function check(ValueObject $valueObject)
    {
        foreach ($valueObject->mandatory() as $key => $value) {
            if (isset($value['when'])) {
                $propertyName = $value['when']['property'];
                $propertyValue = $value['when']['value'];
                if ($valueObject->get($propertyName) === $propertyValue) {
                    self::ensureHasPropery($valueObject, $key,
                        $message = 'When property `' . $propertyName . '` has value '
                            . '`' . $propertyValue . '` also `' . $key . '` is mandatory'
                    );
                }
            }

            /** @todo use only one kind ('when', 'if', ...)  instead of two */
            $mandatoryIfPresentAnotherValue = isset($value['if_present'])
                ? $valueObject->hasProperty($value['if_present'])
                : false;
            if (!is_numeric($key) && $mandatoryIfPresentAnotherValue) {
                self::ensureHasPropery($valueObject, $key,
                    $message = "Property `" . get_class($valueObject)
                    . "::\${$key}` is mandatory but not set"
                );
            }

            if (is_numeric($key) && $valueObject->hasNotProperty($value)) {
                if (!isset($valueObject->defaults()[$value])) {
                    throw new RuntimeException(
                        "Property `" . get_class($valueObject)
                        . "::\$$value` is mandatory but not set"
                    );
                }
            }
        }
    }
}

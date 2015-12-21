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
                $propertyValue = $value['when']['value'];
                if ($valueObject->get($propertyName) === $propertyValue) {
                    throw new RuntimeException(
                        'When property `' . $propertyName . '` has value '
                        . '`' . $propertyValue . '` also `' . $key . '` '
                        . 'is mandatory'
                    );
                }
            }

            if (is_numeric($key) && $valueObject->hasNotProperty($value)) {
                if (!isset($valueObject->defaults()[$value])) {
                    throw new RuntimeException(
                        "Property `" . get_class($valueObject)
                        . "::\$$value` is mandatory but not set"
                    );
                }
            }

            $mandatoryIfPresentAnotherValue = false;
            if (isset($value['if_present'])) {
                $mandatoryIfPresentAnotherValue = $valueObject->hasProperty($value['if_present']);
            }

            if (!is_numeric($key) && $mandatoryIfPresentAnotherValue) {
                if ($valueObject->hasNotProperty($key)) {
                    throw new RuntimeException(
                        "Property `" . get_class($valueObject)
                        . "::\${$key}` is mandatory but not set"
                    );
                }
            }
        }
    }
}

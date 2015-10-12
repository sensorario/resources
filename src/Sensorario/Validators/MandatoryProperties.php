<?php

namespace Sensorario\Validators;

use RuntimeException;
use Sensorario\ValueObject\ValueObject;

final class MandatoryProperties implements Validator
{
    public static function check(ValueObject $valueObject)
    {
        foreach ($valueObject->mandatory() as $key => $value) {
            if (is_numeric($key) && $valueObject->hasNotProperty($value)) {
                if (!isset($valueObject->defaults()[$value])) {
                    throw new RuntimeException(
                        "Property `" . get_class($valueObject)
                        . "::\$$value` is mandatory but not set"
                    );
                }
            }

            if (!is_numeric($key) && $valueObject->hasProperty($value['if_present'])) {
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

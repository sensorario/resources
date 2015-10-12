<?php

namespace Sensorario\Validators;

use RuntimeException;
use Sensorario\ValueObject\ValueObject;

final class AllowedValues implements Validator
{
    public static function check(ValueObject $valueObject)
    {
        foreach ($valueObject->properties() as $key => $value) {
            if (isset($valueObject->allowedValues()[$key])) {
                if (!in_array($value, $valueObject->allowedValues()[$key])) {
                    throw new RuntimeException(
                        'Value `' . $value . '` is not allowed '
                        . 'for key `' . $key . '`'
                    );
                }
            }
        }
    }
}

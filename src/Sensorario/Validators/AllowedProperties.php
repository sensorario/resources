<?php

namespace Sensorario\Validators;

use RuntimeException;
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

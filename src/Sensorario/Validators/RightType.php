<?php

namespace Sensorario\Validators;

use RuntimeException;
use Sensorario\ValueObject\ValueObject;

final class RightType implements Validator
{
    public static function check(ValueObject $valueObject)
    {
        foreach ($valueObject->properties() as $key => $value) {
            if (isset($valueObject->types()[$key])) {
                $type = $valueObject->types()[$key];

                if (!is_object($valueObject->get($key))) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be an object'
                    );
                }

                if (get_class($valueObject->get($key)) != $type) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be an object of type ' . $type
                    );
                }
            }
        }
    }
}

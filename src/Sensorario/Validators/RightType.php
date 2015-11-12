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

                if (gettype($valueObject->get($key)) !== key($type)) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be of type `'
                        . (key($type) == 'scalar' ? current($type) : 'object')
                        . '`'
                    );
                }

                if (get_class($valueObject->get($key)) != current($type)) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be an object of type ' . current($type)
                    );
                }
            }
        }
    }
}

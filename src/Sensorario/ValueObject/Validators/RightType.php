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

final class RightType implements Validator
{
    public static function check(ValueObject $valueObject)
    {
        foreach ($valueObject->properties() as $key => $value) {
            if (isset($valueObject->types()[$key])) {
                $type = $valueObject->types()[$key];

                $expectedType = 'undefined';
                if (isset($type['object'])) {
                    $expectedType = $type['object'];
                }

                if (gettype($valueObject->get($key)) !== key($type)) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be of type `'
                        . (key($type) == 'scalar' ? current($type) : $expectedType)
                        . '`'
                    );
                }
                
                if (
                    !($valueObject->get($key) instanceof \Sensorario\ValueObject\ValueObject) &&
                    get_class($valueObject->get($key)) != current($type)
                )  {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be an object of type ' . current($type)
                    );
                }
            }
        }
    }
}

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
            if (isset($valueObject->rules()[$key])) {
                $rule = $valueObject->rules()[$key];

                if (gettype($valueObject->get($key)) !== key($rule)) {
                    $expectedType = isset($rule['object'])
                        ? $rule['object']
                        : 'undefined';

                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be of type `'
                        . (key($rule) == 'scalar' ? current($rule) : $expectedType)
                        . '`'
                    );
                }
                
                if (
                    !($valueObject->get($key) instanceof \Sensorario\ValueObject\ValueObject) &&
                    get_class($valueObject->get($key)) != current($rule)
                ) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be an object of type ' . current($rule)
                    );
                }
            }
        }
    }
}

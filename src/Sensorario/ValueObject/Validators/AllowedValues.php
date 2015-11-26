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

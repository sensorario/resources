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

use Sensorario\ValueObject\ValueObject;

final class ValueObjectValidator
{
    public static function validate(ValueObject $valueObject)
    {
        $validators = [
            'RightType',
            'MandatoryProperties',
            'AllowedProperties',
            'AllowedValues',
        ];

        foreach ($validators as $name) {
            $validator = 'Sensorario\\ValueObject\\Validators\\' . $name;
            $validator::check($valueObject);
        }
    }
}

<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Validators;

use RuntimeException;
use Sensorario\Resources\Interfaces\Validator;
use Sensorario\Resources\Resource;

final class AllowedValues implements Validator
{
    public static function check(Resource $resource)
    {
        foreach ($resource->properties() as $key => $value) {
            if (isset($resource->allowedValues()[$key])) {
                $allowedValues = $resource->allowedValues()[$key];
                if (!in_array($value, $allowedValues)) {
                    throw new RuntimeException(
                        'Value `' . $value . '` is not allowed '
                        . 'for key `' . $key . '`. '
                        . 'Allowed values are: ' . var_export($allowedValues, true)
                    );
                }
            }
        }
    }
}

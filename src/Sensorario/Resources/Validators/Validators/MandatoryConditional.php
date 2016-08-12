<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Validators\Validators;

use RuntimeException;
use Sensorario\Resources\Resource;
use Sensorario\Resources\Validators\Interfaces\Validator;

final class MandatoryConditional implements Validator
{
    public static function check(Resource $resource)
    {
        foreach ($resource->mandatory() as $key => $value) {
            if (isset($value['when']['has_value'])) {
                $propertyName = $value['when']['property'];
                $propertyValue = $value['when']['has_value'];

                if (is_array($propertyValue)) {
                    foreach ($propertyValue as $value) {
                        if ($resource->get($propertyName) === $value && $resource->hasNotProperty($key)) {
                            throw new RuntimeException(
                                'When property `' . $key . '` has value '
                                . '`' . $value . '` also `' . $key . '` is mandatory'
                            );
                        }
                    }
                } else {
                    if ($resource->get($propertyName) === $propertyValue && $resource->hasNotProperty($key)) {
                        throw new RuntimeException(
                            'When property `' . $propertyName . '` has value '
                            . '`' . $propertyValue . '` also `' . $key . '` is mandatory'
                        );
                    }
                }
            }
        }
    }
}

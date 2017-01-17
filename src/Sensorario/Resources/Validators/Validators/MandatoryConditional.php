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
    public function check(Resource $resource)
    {
        foreach ($resource->mandatory() as $key => $value) {
            if (isset($value['when']['has_value'])) {
                $name = $value['when']['property'];
                $value = $value['when']['has_value'];

                if ($isArray = is_array($value)) {
                    foreach ($value as $value) {
                        if ($resource->get($name) === $value && $resource->hasNotProperty($key)) {
                            static::exceptionMessage($key, $value, $key);
                        }
                    }
                }

                if (!$isArray) {
                    if ($resource->get($name) === $value && $resource->hasNotProperty($key)) {
                        self::exceptionMessage($name, $value, $key);
                    }
                }
            }
        }
    }

    private static function exceptionMessage($name, $value, $key)
    {
        throw new RuntimeException(
            'When property `' . $name . '` '
            . 'has value ' . '`' . $value . '` '
            . 'also `' . $key . '` is mandatory'
        );
    }
}

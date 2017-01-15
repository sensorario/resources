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

final class MandatoryProperty implements Validator
{
    public function check(Resource $resource)
    {
        foreach ($resource->mandatory() as $key => $value) {
            if (
                isset($value['when']['condition']) &&
                $value['when']['condition'] === 'is_present' &&
                $resource->hasProperty($value['when']['property']) &&
                $resource->hasNotProperty($key)
            ) {
                throw new RuntimeException(
                    "Property `" . get_class($resource)
                    . "::\${$key}` is mandatory but not set"
                );
            }
        }
    }
}

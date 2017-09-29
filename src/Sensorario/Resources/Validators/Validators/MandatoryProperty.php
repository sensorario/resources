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

use Sensorario\Resources\Resource;
use Sensorario\Resources\Validators\Interfaces\Validator;

final class MandatoryProperty implements Validator
{
    public function check(Resource $resource)
    {
        foreach ($resource->mandatory() as $key => $value) {
            if (isset($value['when']['condition'])) {
                throw new \Sensorario\Resources\Exceptions\PropertyNotSetException(
                    "Property `" . get_class($resource)
                    . "::\${$key}` is mandatory but not set"
                );
            }
        }
    }
}

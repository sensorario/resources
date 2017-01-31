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

final class MandatoryWithoutDefault implements Validator
{
    public function check(Resource $resource)
    {
        foreach ($resource->mandatory() as $key => $value) {
            if (
                is_numeric($key) &&
                $resource->hasNotProperty($value) &&
                !isset($resource->defaults()[$value])
            ) {
                throw new \Sensorario\Resources\Exceptions\PropertyException(
                    "Property `" . get_class($resource)
                    . "::\$$value` is mandatory but not set. "
                    . "Mandatory fields are: "
                    . join(',', $resource->mandatory())
                    . "."
                );
            }
        }
    }
}

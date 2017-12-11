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
        foreach ($resource->mandatory() as $mandatoryProperty => $value) {
            if (isset($value['when']['condition'])) {
                $when = $value['when'];
                if ('is_present' == $when['condition']) {
                    if (!$resource->hasProperty($mandatoryProperty)) {
                        throw new \Sensorario\Resources\Exceptions\PropertyNotSetException(
                            "Property `" . get_class($resource)
                            . "::\${$mandatoryProperty}` is mandatory but not set"
                        );
                    }
                }
            }
        }
    }
}

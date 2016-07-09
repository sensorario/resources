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

final class AllowedProperties implements Validator
{
    public static function check(Resource $resource)
    {
        $allowed = array_merge(
            $resource->allowed(),
            $resource->mandatory()
        );

        foreach ($resource->properties() as $key => $property) {
            if (!in_array($key, $allowed)) {
                $isAllowedByDependency = false;
                foreach ($allowed as $kk => $vv) {
                    if (!is_numeric($kk) && $resource->hasProperty($vv['when']['property'])) {
                        $isAllowedByDependency = true;
                    }
                }

                if (!$isAllowedByDependency) {
                    throw new RuntimeException(
                        "Key `" . get_class($resource)
                        . "::\$$key` is not allowed"
                    );
                }
            }
        }
    }
}

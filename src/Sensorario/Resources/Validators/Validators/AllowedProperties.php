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

final class AllowedProperties implements Validator
{
    public function check(Resource $resource)
    {
        $allowed = array_merge(
            $resource->allowed(),
            $resource->mandatory()
        );

        foreach ($resource->properties() as $key => $value) {
            if (!in_array($key, $allowed)) {
                $isAllowed = false;

                foreach ($allowed as $kk => $vv) {
                    if (!is_numeric($kk) && $resource->hasProperty($vv['when']['property'])) {
                        $isAllowed = true;
                    }
                }

                if (!$isAllowed) {
                    throw new \Sensorario\Resources\Exceptions\NotAllowedKeyException(
                        "Key `" . get_class($resource)
                        . "::\$$key` with value `" . $value
                        . "` is not allowed"
                    );
                }
            }
        }
    }
}

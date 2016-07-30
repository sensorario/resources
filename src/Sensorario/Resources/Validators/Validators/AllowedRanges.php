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

final class AllowedRanges implements Validator
{
    public static function check(Resource $resource)
    {
        foreach ($resource->properties() as $key => $value) {
            if (isset($resource->ranges()[$key])) {
                if ($value < $resource->ranges()[$key]['more_than']) {
                    throw new RuntimeException(
                        'Value `' . $value . '` is out of range: '
                        . '`'
                        . $resource->ranges()[$key]['more_than']
                        . ' to '
                        . $resource->ranges()[$key]['more_than']
                        . '`.'
                    );
                }
            }
        }
    }
}

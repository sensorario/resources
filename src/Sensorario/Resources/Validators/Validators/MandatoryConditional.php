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

final class MandatoryConditional implements Validator
{
    public function check(Resource $resource)
    {
        foreach ($resource->mandatory() as $key => $value) {
            if (isset($value['when']['has_value'])) {
                $name = $value['when']['property'];
                $value = $value['when']['has_value'];

                if (is_array($value)) {
                    foreach ($value as $item) {
                        $this->ensurePropertyNameHasKey($resource, $item, $name, $key);
                    }
                } else {
                    $this->ensurePropertyNameHasKey($resource, $value, $name, $key);
                }
            }
        }
    }

    public function ensurePropertyNameHasKey(Resource $resource, $value, $name, $key)
    {
        if ($resource->get($name) === $value && $resource->hasNotProperty($key)) {
            throw new \Sensorario\Resources\Exceptions\PropertyException(
                'When property `' . $name . '` '
                . 'has value ' . '`' . $value . '` '
                . 'also `' . $key . '` is mandatory'
            );
        }
    }
}

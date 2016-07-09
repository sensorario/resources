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

final class RightType implements Validator
{
    public static function check(Resource $resource)
    {
        foreach ($resource->properties() as $key => $value) {
            if (isset($resource->rules()[$key])) {
                $rule = $resource->rules()[$key];

                if (gettype($resource->get($key)) !== key($rule)) {
                    $expectedType = isset($rule['object'])
                        ? $rule['object']
                        : 'undefined';

                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be of type `'
                        . (key($rule) == 'scalar' ? current($rule) : $expectedType)
                        . '`'
                    );
                }
                
                if (
                    !($resource->get($key) instanceof \Sensorario\Resources\Resource) &&
                    get_class($resource->get($key)) != current($rule)
                ) {
                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be an object of type ' . current($rule)
                    );
                }
            }
        }
    }
}

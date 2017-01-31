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

final class RewriteValues implements Validator
{
    public function check(Resource $resource)
    {
        foreach ($resource->properties() as $key => $value) {
            if (isset($resource->rewrites()[$key])) {
                $when = $resource->rewrites()[$key]['when']; 
                $set = $resource->rewrites()[$key]['set']; 

                if (isset($when['greater_than'])) {
                    if ($resource->get($key) > $resource->get($when['greater_than'])) {
                        $resource->set($key, $resource->get($set['equals_to']));
                    }
                }
            }
        }
    }
}

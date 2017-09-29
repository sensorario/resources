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

                $this->overwriteValueIfGreaterThan($when, $resource, $key);
            }
        }
    }

    public function overwriteValueIfGreaterThan($when, $resource, $propertyToBeReplaced)
    {
        if (isset($when['greater_than']) && $resource->get($propertyToBeReplaced) > $resource->get($when['greater_than'])) {
            $resource->set(
                $propertyToBeReplaced,
                $resource->get($resource->rewrites()[$propertyToBeReplaced]['set']['equals_to'])
            );
        }
    }
}

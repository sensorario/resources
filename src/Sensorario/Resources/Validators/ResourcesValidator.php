<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com> *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Validators;

use Sensorario\Container\Container;
use Sensorario\Resources\Resource;

final class ResourcesValidator
{
    public function validate(Resource $resource)
    {
        $container = ValidatorContainer::load();

        $validators = [
            'right.type',
            'mandatory.conditional',
            'mandatory.property',
            'mandatory.without.default',
            'allowed.properties',
            'allowed.values',
            'rewrite.values',
            'allowed.ranges',
            'right.type',
        ];

        foreach ($validators as $name) {
            if ($container->contains($name)) {
                $validator = $container->get($name);
            }

            $validator->check($resource);
        }
    }
}

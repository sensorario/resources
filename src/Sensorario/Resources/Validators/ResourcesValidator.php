<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com> *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Validators;

use Sensorario\Resources\MagicResource;

final class ResourcesValidator
{
    public function validate(MagicResource $resource)
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
                $container->get($name)->check($resource);
            }
        }
    }
}

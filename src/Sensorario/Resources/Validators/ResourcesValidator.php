<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Validators;

use Sensorario\Resources\Resource;

final class ResourcesValidator
{
    public static function validate(Resource $resource)
    {
        $validators = [
            'RightType',
            'MandatoryConditional',
            'MandatoryProperty',
            'MandatoryWithoutDefault',
            'AllowedProperties',
            'AllowedValues',
        ];

        foreach ($validators as $name) {
            $validator = 'Sensorario'
                .'\\Resources'
                .'\\Validators'
                .'\\Validators'
                .'\\' . $name
            ;
            $validator::check($resource);
        }
    }
}

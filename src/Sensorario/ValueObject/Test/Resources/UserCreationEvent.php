<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Resources;

use Sensorario\ValueObject\ValueObject;

final class UserCreationEvent extends ValueObject
{
    public static function mandatory()
    {
        return [
            'type',
            'username' => [
                'when' => [
                    'property' => 'type',
                    'value' => 'human'
                ]
            ]
        ];
    }

    /** @todo improve allowed fields: if is mandatory, with condition, must be automatically allowed */
    public static function allowed()
    {
        return [
            'username',
        ];
    }

    public static function allowedValues()
    {
        return [
            'type' => [
                'human',
                'bot'
            ],
        ];
    }
}

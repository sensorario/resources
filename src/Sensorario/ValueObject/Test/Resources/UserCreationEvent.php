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
    const TYPE     = 'type';
    const USERNAME = 'username';

    public static function mandatory()
    {
        return [
            UserCreationEvent::TYPE,
            UserCreationEvent::USERNAME => [
                'when' => [
                    'property' => 'type',
                    'has_value' => [
                        'human',
                        'guest',
                    ]
                ]
            ]
        ];
    }

    public static function allowedValues()
    {
        return [
            UserCreationEvent::TYPE => [
                'guest',
                'human',
                'bot'
            ],
        ];
    }
}

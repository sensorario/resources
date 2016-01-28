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

final class SomeApiRequest extends ValueObject
{
    public static function mandatory()
    {
        return [
            'someApiParameter',
        ];
    }

    public static function allowed()
    {
        return [
            'fields',
        ];
    }

    public static function allowedValues()
    {
        return [
            'someApiParameter' => [
                'hello',
                'world'
            ],
        ];
    }

    public static function rules()
    {
        return [
            'fields' => [
                'scalar' => 'array'
            ]
        ];
    }
}

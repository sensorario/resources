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
    const SOME_API_PARAMETER = 'someApiParameter';
    const FIELDS             = 'fields';

    public static function mandatory()
    {
        return [
            SomeApiRequest::SOME_API_PARAMETER,
        ];
    }

    public static function allowed()
    {
        return [
            SomeApiRequest::FIELDS,
        ];
    }

    public static function allowedValues()
    {
        return [
            SomeApiRequest::SOME_API_PARAMETER => [
                'hello',
                'world'
            ],
        ];
    }

    public static function rules()
    {
        return [
            SomeApiRequest::FIELDS => [
                'scalar' => 'array'
            ]
        ];
    }
}

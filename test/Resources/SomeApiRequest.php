<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Resources;

use Sensorario\Resources\Resource;

final class SomeApiRequest extends Resource
{
    const SOME_API_PARAMETER = 'someApiParameter';
    const FIELDS             = 'fields';

    public function mandatory()
    {
        return [
            SomeApiRequest::SOME_API_PARAMETER,
        ];
    }

    public function allowed()
    {
        return [
            SomeApiRequest::FIELDS,
        ];
    }

    public function allowedValues()
    {
        return [
            SomeApiRequest::SOME_API_PARAMETER => [
                'hello',
                'world'
            ],
        ];
    }

    public function rules()
    {
        return [
            SomeApiRequest::FIELDS => [
                'scalar' => 'array'
            ]
        ];
    }
}

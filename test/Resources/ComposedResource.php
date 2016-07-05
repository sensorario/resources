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

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\Resources\Resource;

final class ComposedResource extends Resource
{
    const CREDENTIALS = 'credentials';

    public static function mandatory()
    {
        return [
            ComposedResource::CREDENTIALS,
        ];
    }

    public static function rules()
    {
        return [
            ComposedResource::CREDENTIALS => [
                'object' => '\Sensorario\Resources\Resource',
            ]
        ];
    }
}


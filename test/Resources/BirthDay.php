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

final class BirthDay extends Resource
{
    const DATE = 'date';

    public static function allowed()
    {
        return [
            BirthDay::DATE,
        ];
    }

    public static function rules()
    {
        return [
            BirthDay::DATE => [
                'object' => 'DateTime',
            ]
        ];
    }
}

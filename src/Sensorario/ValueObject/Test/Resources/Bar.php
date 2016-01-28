<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Test\Resources;

use Sensorario\ValueObject\ValueObject;

final class Bar extends ValueObject
{
    const NAME = 'name';

    public static function allowed()
    {
        return [
            Bar::NAME,
        ];
    }

    public static function defaults()
    {
        return [
            Bar::NAME => 'Firefox',
        ];
    }
}

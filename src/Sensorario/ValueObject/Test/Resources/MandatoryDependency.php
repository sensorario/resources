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

final class MandatoryDependency extends ValueObject
{
    public static function mandatory()
    {
        return [
            'foo',
            'hello' => [
                'if_present' => 'world',
            ]
        ];
    }

    public static function allowed()
    {
        return [
            'hello',
            'world',
        ];
    }
}

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

final class ValueObjectWithoutRules extends ValueObject
{
    const DATETIME = 'datetime';

    public static function mandatory()
    {
        return [
            ValueObjectWithoutRules::DATETIME,
        ];
    }
}

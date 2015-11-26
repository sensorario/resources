<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Helpers;

use Sensorario\ValueObject\ValueObject;

final class JsonExporter
{
    public static function fromValueObject(ValueObject $value)
    {
        $jsonResult = [];

        foreach ($value->properties() as $key => $value) {
            $jsonResult[$key] = $value;
        }

        return json_encode(
            $jsonResult
        );
    }
}

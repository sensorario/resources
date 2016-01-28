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

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\ValueObject\ValueObject;

final class ComposedValueObject extends ValueObject
{
    const CREDENTIALS = 'credentials';

    public static function mandatory()
    {
        return [
            ComposedValueObject::CREDENTIALS,
        ];
    }

    public static function rules()
    {
        return [
            ComposedValueObject::CREDENTIALS => [
                'object' => '\Sensorario\ValueObject\ValueObject',
            ]
        ];
    }
}


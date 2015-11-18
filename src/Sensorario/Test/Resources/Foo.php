<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Test\Resources;

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\ValueObject\ValueObject;

final class Foo extends ValueObject
{
    public static function mandatory()
    {
        return [
            'name',
        ];
    }

    public static function allowed()
    {
        return [
            'name',
            'surname',
        ];
    }
}

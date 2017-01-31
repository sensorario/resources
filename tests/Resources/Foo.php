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

final class Foo extends Resource
{
    const NAME    = 'name';
    const SURNAME = 'surname';

    public function mandatory()
    {
        return [
            Foo::NAME,
        ];
    }

    public function allowed()
    {
        return [
            Foo::NAME,
            Foo::SURNAME,
        ];
    }
}

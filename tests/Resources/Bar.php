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

final class Bar extends Resource
{
    const NAME = 'name';

    public function allowed()
    {
        return [
            Bar::NAME,
        ];
    }

    public function defaults()
    {
        return [
            Bar::NAME => 'Firefox',
        ];
    }
}

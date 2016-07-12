<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Interfaces;

interface ResourceInterface
{
    public static function allowed();

    public static function allowedValues();

    public static function mandatory();

    public static function rules();
}

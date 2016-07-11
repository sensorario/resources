<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources;

use RuntimeException;

class Resource
    extends MagicResource
    implements Interfaces\ResourceInterface
{
    protected static $allowed = [];

    public static function mandatory()
    {
        return [];
    }

    public static function allowed()
    {
        return static::$allowed;
    }

    public static function allowedValues()
    {
        return [];
    }

    public static function rules()
    {
        return [];
    }

    public function applyConfiguration(
        $resourceName,
        Container $config
    ) {
        static::$allowed = $config->allowed($resourceName);
    }
}

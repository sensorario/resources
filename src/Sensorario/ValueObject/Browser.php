<?php

/**
 * This is an empty value object
 */

namespace Sensorario\ValueObject;

/**
 * This is an empty value object
 */
final class Browser extends ValueObject
{
    public static function allowed()
    {
        return [
            'name'
        ];
    }

    public static function defaults()
    {
        return [
            'name' => 'Firefox',
        ];
    }
}

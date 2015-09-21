<?php

/**
 * An example of value object
 */

namespace Sensorario\ValueObject;

/**
 * A value object called Full Name
 */
final class FullNameValueObject extends ValueObject
{
    /**
     * Mandatory fields for a value object of this type are name and surname
     */
    protected static function mandatory()
    {
        return [
            'name',
            'surname',
        ];
    }
}

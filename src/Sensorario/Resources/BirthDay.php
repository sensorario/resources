<?php

namespace Sensorario\Resources;

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\ValueObject\ValueObject;

final class BirthDay extends ValueObject
{
    public static function allowed()
    {
        return [
            'date',
        ];
    }

    public static function types()
    {
        return [
            'date' => 'DateTime',
        ];
    }
}

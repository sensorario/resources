<?php

namespace Sensorario\Services;

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\ValueObject\ValueObject;
use Sensorario\Resources\BirthDay;
use Sensorario\Resources\Foo;

final class PropertyTypeTest extends PHPUnit_Framework_TestCase
{
    public function testPropertiesTypeWhenObject()
    {
        $birthday = BirthDay::box([
            'date' => new DateTime('2015'),
        ]);

        $this->assertEquals(
            'DateTime',
            PropertyType::asString(
                $birthday,
                'date'
            )
        );
    }

    public function testPropertiesTypeWhenString()
    {
        $foo = Foo::box([
            'name' => 'Simone'
        ]);

        $this->assertEquals(
            'string',
            PropertyType::asString(
                $foo,
                'name'
            )
        );
    }

}


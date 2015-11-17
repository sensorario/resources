<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Test\Services;

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\Resources\BirthDay;
use Sensorario\Resources\Foo;
use Sensorario\Services\PropertyType;
use Sensorario\ValueObject\ValueObject;

final class PropertyTypeTest extends PHPUnit_Framework_TestCase
{
    public function testClassNameWhenTypeIsAnObject()
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

    public function testScalarTypeWhenTypeIsAString()
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


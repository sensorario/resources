<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Test\Sensorario\Helpers;

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\ValueObject\Helpers\PropertyTypeExtractor;
use Sensorario\ValueObject\Test\Resources\BirthDay;
use Sensorario\ValueObject\Test\Resources\Foo;
use Sensorario\ValueObject\ValueObject;

final class PropertyTypeExtractorTest extends PHPUnit_Framework_TestCase
{
    public function testClassNameWhenTypeIsAnObject()
    {
        $birthday = BirthDay::box([
            'date' => new DateTime('2015'),
        ]);

        $propertyTypeExtractor = new PropertyTypeExtractor($birthday);
        $propertyTypeExtractor->setPropertyName('date');

        $this->assertEquals(
            'DateTime',
            $propertyTypeExtractor->execute()
        );
    }

    public function testScalarTypeWhenTypeIsAString()
    {
        $foo = Foo::box([
            'name' => 'Simone'
        ]);

        $propertyTypeExtractor = new PropertyTypeExtractor($foo);
        $propertyTypeExtractor->setPropertyName('name');

        $this->assertEquals(
            'string',
            $propertyTypeExtractor->execute()
        );
    }
}


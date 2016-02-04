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
    public function testIsClassName()
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

    /** @dataProvider properties */
    public function testStringTypeIsReturnedWhenStringIsTheValue(
        $propertyValue,
        $propertyType
    )
    {
        $foo = Foo::box([
            'name' => $propertyValue
        ]);

        $propertyTypeExtractor = new PropertyTypeExtractor($foo);
        $propertyTypeExtractor->setPropertyName('name');

        $this->assertEquals(
            $propertyType,
            $propertyTypeExtractor->execute()
        );
    }

    public function properties()
    {
        return [
            ['Simone', 'string'],
            [42, 'integer'],
        ];
    }
}


<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Test\Sensorario\Helpers;

use DateTime;
use PHPUnit\Framework\TestCase;
use Sensorario\Resources\Helpers\PropertyTypeExtractor;
use Resources\BirthDay;
use Resources\Foo;

final class PropertyTypeExtractorTest extends TestCase
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


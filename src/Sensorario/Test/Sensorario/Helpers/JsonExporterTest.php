<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Test\Sensorario\Helpers;

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\Helpers\JsonExporter;
use Sensorario\Test\Resources\BirthDay;
use Sensorario\ValueObject\ValueObject;

final class JsonExporterTest extends PHPUnit_Framework_TestCase
{
    public function testCouldExportInJsonFormat()
    {
        $expectedJsonFormat = json_encode([
            'date' => (new DateTime('10 september 1982'))
        ]);

        $this->assertEquals(
            $expectedJsonFormat,
            JsonExporter::fromValueObject(
                BirthDay::box([
                    'date' => new DateTime('10 september 1982')
                ])
            )
        );
    }
}


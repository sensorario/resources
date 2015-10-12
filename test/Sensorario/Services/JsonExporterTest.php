<?php

namespace Sensorario\Services;

use DateTime;
use PHPUnit_Framework_TestCase;
use Sensorario\ValueObject\ValueObject;
use Sensorario\Resources\BirthDay;

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


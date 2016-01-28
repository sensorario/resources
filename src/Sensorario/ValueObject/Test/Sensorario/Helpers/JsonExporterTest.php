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
use Sensorario\ValueObject\Helpers\JsonExporter;
use Sensorario\ValueObject\Test\Resources\BirthDay;
use Sensorario\ValueObject\ValueObject\ValueObject;

final class JsonExporterTest extends PHPUnit_Framework_TestCase
{
    public function testCouldExportInJsonFormat()
    {
        $params = [
            'date' => (new DateTime('10 september 1982'))
        ];

        $expectedJsonFormat = json_encode($params);

        $jsonResult = new JsonExporter(
            BirthDay::box($params)
        );

        $this->assertEquals(
            $expectedJsonFormat,
            $jsonResult->execute()
        );
    }
}


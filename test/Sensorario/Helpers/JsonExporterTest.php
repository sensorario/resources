<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Helpers;

use DateTime;
use PHPUnit_Framework_TestCase;
use Resources\BirthDay;
use Sensorario\Resources\Helpers\JsonExporter;
use Sensorario\Resources\Resources\Resource;

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


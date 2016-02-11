<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Helpers;

use Sensorario\ValueObject\ValueObject;
use Sensorario\ValueObject\Interfaces\Helper;

final class JsonExporter implements Helper
{
    private $valueObject;

    private $jsonResult = [];

    public function __construct(ValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    public function execute()
    {
        foreach ($this->valueObject->properties() as $key => $value) {
            $this->jsonResult[$key] = $value;
        }

        return json_encode(
            $this->jsonResult
        );
    }
}

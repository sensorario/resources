<?php

namespace Sensorario\Services;

use Sensorario\ValueObject\ValueObject;

final class JsonExporter
{
    public static function fromValueObject(ValueObject $value)
    {
        $jsonResult = [];

        foreach ($value->properties() as $key => $value) {
            $jsonResult[$key] = $value;
        }

        return json_encode(
            $jsonResult
        );
    }
}

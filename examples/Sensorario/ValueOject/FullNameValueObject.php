<?php

namespace Sensorario\ValueObject;

final class FullNameValueObject extends ValueObject
{
    protected static function mandatory()
    {
        return [
            'name',
            'surname',
        ];
    }
}

<?php

namespace Sensorario\Validators;

use Sensorario\ValueObject\ValueObject;

interface Validator
{
    public static function check(ValueObject $valueObject);
}

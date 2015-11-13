<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Validators;

use Sensorario\ValueObject\ValueObject;

interface Validator
{
    public static function check(ValueObject $valueObject);
}
